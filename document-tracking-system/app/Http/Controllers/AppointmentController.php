<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\OffDay;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function store(Request $request)
    {
        $request->validate([
            'full_name'          => 'required|string|max:255',
            'national_id_number' => 'required|string|max:255',
            'document_type'      => 'required|string|max:255',
            'date'               => 'required|date|after_or_equal:today',
            'time_slot'          => 'required|in:09:00,10:00,11:00,12:00,13:00',
            'notes'              => 'nullable|string|max:500',
        ]);

        if (OffDay::isOffDay($request->date)) {
            return back()->with('error', 'That date is an off day. Please choose another.');
        }

        $taken = Appointment::where('date', $request->date)
            ->where('time_slot', $request->time_slot)
            ->whereNotIn('status', ['cancelled'])
            ->exists();

        if ($taken) {
            return back()->with('error', 'That time slot was just taken. Please choose another.');
        }

        $alreadyBooked = Appointment::where('citizen_id', Auth::id())
            ->where('date', $request->date)
            ->whereNotIn('status', ['cancelled'])
            ->exists();

        if ($alreadyBooked) {
            return back()->with('error', 'You already have an appointment on that day.');
        }

        Appointment::create([
            'citizen_id'         => Auth::id(),
            'full_name'          => $request->full_name,
            'national_id_number' => $request->national_id_number,
            'document_type'      => $request->document_type,
            'date'               => $request->date,
            'time_slot'          => $request->time_slot,
            'notes'              => $request->notes,
        ]);

        return redirect()->route('citizen.appointments.calendar')
            ->with('success', 'Appointment booked for ' . $request->date . ' at ' . $request->time_slot . '.');
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
}
