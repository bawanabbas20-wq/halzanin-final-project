<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Application;
use App\Models\Document;
use App\Models\Ministry;
use App\Models\OffDay;
use App\Models\Service;
use App\Models\StatusLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AppointmentController extends Controller
{
    // Entry point: ministry + service picker
    public function index()
    {
        $ministries = Ministry::with('services')->orderBy('order')->get();
        return view('citizen.appointments.index', compact('ministries'));
    }

    // Per-service booking calendar
    public function calendar(Request $request, string $ministrySlug, string $serviceSlug)
    {
        $ministry = Ministry::where('slug', $ministrySlug)->firstOrFail();
        $service  = $ministry->services()
                             ->where('slug', $serviceSlug)
                             ->where('is_active', true)
                             ->firstOrFail();

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
            ->where('service_id', $service->id)
            ->whereNotIn('status', ['cancelled'])
            ->selectRaw('date, COUNT(*) as count')
            ->groupBy('date')
            ->pluck('count', 'date')
            ->toArray();

        $offDates     = OffDay::offDatesForMonth($year, $month, $ministry->id);
        $canPrev      = $current->gt(now()->startOfMonth());
        $canNext      = $current->lt($maxDate->copy()->startOfMonth());
        $vaultTypeMap = $this->buildVaultTypeMap($service->required_documents ?? []);

        return view('citizen.appointments.calendar', compact(
            'ministry', 'service', 'year', 'month', 'current',
            'counts', 'offDates', 'maxDate', 'canPrev', 'canNext',
            'vaultTypeMap'
        ));
    }

    public function monthData(Request $request)
    {
        $year      = (int) $request->get('year', now()->year);
        $month     = (int) $request->get('month', now()->month);
        $serviceId = $request->integer('service_id') ?: null;

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

        $query = Appointment::where('date', 'like', $current->format('Y-m') . '-%')
            ->whereNotIn('status', ['cancelled']);

        if ($serviceId) {
            $query->where('service_id', $serviceId);
        }

        $counts = $query->selectRaw('date, COUNT(*) as count')
            ->groupBy('date')
            ->pluck('count', 'date')
            ->toArray();

        $ministryId = $serviceId ? Service::find($serviceId)?->ministry_id : null;
        $offDates   = OffDay::offDatesForMonth($year, $month, $ministryId);

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
        $date       = $request->get('date');
        $serviceId  = $request->integer('service_id') ?: null;
        $ministryId = $serviceId ? Service::find($serviceId)?->ministry_id : null;

        if (!$date || OffDay::isOffDay($date, $ministryId) || Carbon::parse($date)->lt(now()->startOfDay())) {
            return response()->json(['slots' => [], 'error' => 'Date not available']);
        }

        $existing = Appointment::where('citizen_id', Auth::id())
            ->where('date', $date)
            ->when($serviceId, fn($q) => $q->where('service_id', $serviceId))
            ->whereNotIn('status', ['cancelled'])
            ->first();

        if ($existing) {
            return response()->json([
                'slots'    => [],
                'error'    => 'You already have an appointment on this day.',
                'existing' => ['time_slot' => $existing->time_slot, 'status' => $existing->status],
            ]);
        }

        return response()->json(['slots' => Appointment::availableSlotsForDate($date, $serviceId)]);
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
            'service_id'         => 'required|exists:services,id',
            'full_name'          => 'required|string|min:2|max:255',
            'national_id_number' => 'required|string|max:50',
            'document_type'      => 'required|string|max:100',
            'date'               => 'required|date|after_or_equal:today',
            'time_slot'          => 'required|in:09:00,10:00,11:00,12:00,13:00',
            'notes'              => 'nullable|string|max:500',
            'docs'               => 'nullable|array|max:10',
            'docs.*.name'        => 'required_with:docs|string|max:255',
            'docs.*.source'      => 'required_with:docs|in:vault,upload,confirmed',
            'doc_files.*'        => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $service = Service::findOrFail($request->service_id);

        if (OffDay::isOffDay($request->date, $service->ministry_id)) {
            if ($request->ajax()) {
                return response()->json(['message' => 'That date is an off day. Please choose another.'], 422);
            }
            return back()->with('error', 'That date is an off day. Please choose another.');
        }

        $taken = Appointment::where('date', $request->date)
            ->where('time_slot', $request->time_slot)
            ->where('service_id', $request->service_id)
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
            ->where('service_id', $request->service_id)
            ->whereNotIn('status', ['cancelled'])
            ->exists();

        if ($alreadyBooked) {
            if ($request->ajax()) {
                return response()->json(['message' => 'You already have an appointment on that day for this service.'], 422);
            }
            return back()->with('error', 'You already have an appointment on that day for this service.');
        }

        [, $application] = DB::transaction(function () use ($request, $service) {
            $appointment = Appointment::create([
                'citizen_id'         => Auth::id(),
                'service_id'         => $request->service_id,
                'full_name'          => $request->full_name,
                'national_id_number' => $request->national_id_number,
                'document_type'      => $request->document_type,
                'date'               => $request->date,
                'time_slot'          => $request->time_slot,
                'notes'              => $request->notes,
            ]);

            $application = Application::create([
                'user_id'        => Auth::id(),
                'service_id'     => $request->service_id,
                'appointment_id' => $appointment->id,
                'tracking_code'  => $this->generateTrackingCode(),
                'current_status' => 'submitted',
                'submitted_at'   => now(),
            ]);

            StatusLog::create([
                'application_id' => $application->id,
                'status'         => 'submitted',
                'changed_by'     => Auth::id(),
                'notes'          => 'Application submitted via ' . $service->name . ' appointment.',
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

    /**
     * Build a map of required document names → matching vault document types.
     * Enables the booking wizard to auto-match vault documents to requirements.
     */
    private function buildVaultTypeMap(array $requiredDocs): array
    {
        $keywords = [
            'passport'    => 'Passport',
            'national id' => 'National ID',
            'birth cert'  => 'Birth Certificate',
            'driving'     => 'Driving License',
            'business'    => 'Business License',
            'license'     => 'Driving License',
        ];

        $map = [];
        foreach ($requiredDocs as $doc) {
            $lower = strtolower($doc);
            $types = [];
            foreach ($keywords as $keyword => $vaultType) {
                if (str_contains($lower, $keyword) && !in_array($vaultType, $types)) {
                    $types[] = $vaultType;
                }
            }
            $map[$doc] = $types;
        }
        return $map;
    }
}
