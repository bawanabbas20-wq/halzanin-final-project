<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Application;
use App\Models\Document;
use App\Models\OffDay;
use App\Models\StatusLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AppointmentController extends Controller
{
    public function calendar(Request $request)
    {
        $year  = (int) $request->get('year', now()->year);
        $month = (int) $request->get('month', now()->month);

        $current = Carbon::createFromDate($year, $month, 1);
        $maxDate = now()->addMonths(3)->endOfMonth();

        if ($current->lt(now()->startOfMonth())) {
            $current = now()->startOfMonth();
        }
        if ($current->gt($maxDate->copy()->startOfMonth())) {
            $current = $maxDate->copy()->startOfMonth();
        }

        $year  = $current->year;
        $month = $current->month;

        $counts = Appointment::where('date', 'like', $current->format('Y-m') . '-%')
            ->whereNotIn('status', ['cancelled'])
            ->selectRaw('date, COUNT(*) as count')
            ->groupBy('date')
            ->pluck('count', 'date')
            ->toArray();

        $offDates = OffDay::offDatesForMonth($year, $month);

        $canPrev = $current->gt(now()->startOfMonth());
        $canNext = $current->lt($maxDate->copy()->startOfMonth());

        return view('citizen.appointments.calendar', compact(
            'year', 'month', 'current', 'counts', 'offDates', 'maxDate', 'canPrev', 'canNext'
        ));
    }

    public function monthData(Request $request)
    {
        $year  = (int) $request->get('year', now()->year);
        $month = (int) $request->get('month', now()->month);

        $current = Carbon::createFromDate($year, $month, 1);
        $maxDate = now()->addMonths(3)->endOfMonth();

        if ($current->lt(now()->startOfMonth())) {
            $current = now()->startOfMonth();
        }
        if ($current->gt($maxDate->copy()->startOfMonth())) {
            $current = $maxDate->copy()->startOfMonth();
        }

        $year  = $current->year;
        $month = $current->month;

        $counts = Appointment::where('date', 'like', $current->format('Y-m') . '-%')
            ->whereNotIn('status', ['cancelled'])
            ->selectRaw('date, COUNT(*) as count')
            ->groupBy('date')
            ->pluck('count', 'date')
            ->toArray();

        $offDates = OffDay::offDatesForMonth($year, $month);

        return response()->json([
            'year'     => $year,
            'month'    => $month,
            'label'    => $current->format('F Y'),
            'counts'   => $counts,
            'offDates' => $offDates,
            'canPrev'  => $current->gt(now()->startOfMonth()),
            'canNext'  => $current->lt($maxDate->copy()->startOfMonth()),
        ]);
    }

    public function slots(Request $request)
    {
        $date = $request->get('date');

        if (!$date || OffDay::isOffDay($date) || Carbon::parse($date)->lt(now()->startOfDay())) {
            return response()->json(['slots' => [], 'error' => 'Date not available']);
        }

        $existing = Appointment::where('citizen_id', Auth::id())
            ->where('date', $date)
            ->whereNotIn('status', ['cancelled'])
            ->first();

        if ($existing) {
            return response()->json([
                'slots'    => [],
                'error'    => 'You already have an appointment on this day.',
                'existing' => ['time_slot' => $existing->time_slot, 'status' => $existing->status],
            ]);
        }

        return response()->json(['slots' => Appointment::availableSlotsForDate($date)]);
    }

    public function vaultDocs()
    {
        $docs = auth()->user()->vaultDocuments()
            ->where('expires_at', '>', now())
            ->orderByDesc('created_at')
            ->get(['id', 'document_type', 'original_name', 'expires_at'])
            ->map(fn($d) => [
                'id'         => $d->id,
                'type'       => $d->document_type,
                'name'       => $d->original_name ?: $d->document_type . ' Scan',
                'expires_in' => (int) now()->diffInDays($d->expires_at),
            ]);

        return response()->json(['docs' => $docs]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name'          => 'required|string|min:2|max:255',
            // SECURITY: tightened to realistic max lengths; Iraqi national IDs are ≤20 chars
            'national_id_number' => 'required|string|max:50',
            'document_type'      => 'required|string|max:100',
            'date'               => 'required|date|after_or_equal:today',
            'time_slot'          => 'required|in:09:00,10:00,11:00,12:00,13:00',
            'notes'              => 'nullable|string|max:500',
            // SECURITY: max:10 prevents submitting hundreds of document entries in one request
            'docs'               => 'nullable|array|max:10',
            'docs.*.name'        => 'required_with:docs|string|max:255',
            'docs.*.source'      => 'required_with:docs|in:vault,upload,confirmed',
            'doc_files.*'        => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        if (OffDay::isOffDay($request->date)) {
            if ($request->ajax()) {
                return response()->json(['message' => 'That date is an off day. Please choose another.'], 422);
            }

            return back()->with('error', 'That date is an off day. Please choose another.');
        }

        $taken = Appointment::where('date', $request->date)
            ->where('time_slot', $request->time_slot)
            ->whereNotIn('status', ['cancelled'])
            ->exists();

        if ($taken) {
            if ($request->ajax()) {
                return response()->json(['message' => 'That time slot was just taken. Please choose another.'], 422);
            }

            return back()->with('error', 'That time slot was just taken. Please choose another.');
        }

        $alreadyBooked = Appointment::where('citizen_id', Auth::id())
            ->where('date', $request->date)
            ->whereNotIn('status', ['cancelled'])
            ->exists();

        if ($alreadyBooked) {
            if ($request->ajax()) {
                return response()->json(['message' => 'You already have an appointment on that day.'], 422);
            }

            return back()->with('error', 'You already have an appointment on that day.');
        }

        [$appointment, $application] = DB::transaction(function () use ($request) {
            $appointment = Appointment::create([
                'citizen_id'         => Auth::id(),
                'full_name'          => $request->full_name,
                'national_id_number' => $request->national_id_number,
                'document_type'      => $request->document_type,
                'date'               => $request->date,
                'time_slot'          => $request->time_slot,
                'notes'              => $request->notes,
            ]);

            $application = Application::create([
                'user_id'        => Auth::id(),
                'appointment_id' => $appointment->id,
                'tracking_code'  => $this->generateTrackingCode(),
                'current_status' => 'submitted',
                'submitted_at'   => now(),
            ]);

            StatusLog::create([
                'application_id' => $application->id,
                'status'         => 'submitted',
                'changed_by'     => Auth::id(),
                'notes'          => 'Application submitted.',
            ]);

            $docInputs = $request->input('docs', []);
            $docFiles  = $request->file('doc_files', []);

            foreach ($docInputs as $i => $docInput) {
                $rec = [
                    'appointment_id' => $appointment->id,
                    'document_name'  => $docInput['name'],
                    'source'         => $docInput['source'],
                ];

                if ($docInput['source'] === 'vault' && !empty($docInput['vault_id'])) {
                    $rec['vault_document_id'] = (int) $docInput['vault_id'];
                } elseif ($docInput['source'] === 'upload' && isset($docFiles[$i])) {
                    $file = $docFiles[$i];
                    $path = $file->store('appointment-docs/' . Auth::id() . '/' . $appointment->id, 'local');
                    $rec['file_path']     = $path;
                    $rec['original_name'] = $file->getClientOriginalName();
                    $rec['file_size']     = $file->getSize();
                }

                Document::create($rec);
            }

            return [$appointment, $application];
        });

        if ($request->ajax()) {
            return response()->json([
                'success'  => true,
                'redirect' => route('citizen.applications.receipt', $application),
                'message'  => 'Appointment booked. Your tracking code is ' . $application->tracking_code . '.',
            ]);
        }

        return redirect()->route('citizen.applications.receipt', $application)
            ->with('success', 'Appointment booked. Your tracking code is ' . $application->tracking_code . '.');
    }

    public function cancel(Appointment $appointment)
    {
        if ($appointment->citizen_id !== Auth::id()) {
            abort(403);
        }

        $appointment->update(['status' => 'cancelled']);

        return redirect()->route('citizen.appointments.calendar')
            ->with('success', 'Appointment cancelled successfully.');
    }

    private function generateTrackingCode(): string
    {
        do {
            $code = 'TRK-' . now()->format('ymd') . '-' . strtoupper(Str::random(6));
        } while (Application::where('tracking_code', $code)->exists());

        return $code;
    }
}
