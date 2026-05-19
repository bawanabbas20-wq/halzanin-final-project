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

        // Clamp: don't go before current month or beyond 3 months
        if ($current->lt(now()->startOfMonth())) {
            $current = now()->startOfMonth();
        }
        if ($current->gt($maxDate->copy()->startOfMonth())) {
            $current = $maxDate->copy()->startOfMonth();
        }

        $year  = $current->year;
        $month = $current->month;

        // Build per-day booking counts for this month
        $counts = Appointment::where('date', 'like', $current->format('Y-m') . '-%')
            ->whereNotIn('status', ['cancelled'])
            ->selectRaw('date, COUNT(*) as count')
            ->groupBy('date')
            ->pluck('count', 'date')
            ->toArray();

        // Admin off days for this month
        $offDates = OffDay::offDatesForMonth($year, $month);

        // Citizen's own appointments
        $myAppointments = Auth::user()->appointments()
            ->where('date', '>=', now()->toDateString())
            ->whereNotIn('status', ['cancelled'])
            ->orderBy('date')->orderBy('time_slot')
            ->get();

        return view('citizen.appointments.calendar', compact(
            'year', 'month', 'current', 'counts', 'offDates', 'myAppointments', 'maxDate'
        ));
    }

    public function slots(Request $request)
    {
        $date = $request->get('date');

        if (!$date || OffDay::isOffDay($date) || Carbon::parse($date)->isPast()) {
            return response()->json(['slots' => [], 'error' => 'Date not available']);
        }

        // Check if past date (allow today)
        if (Carbon::parse($date)->lt(now()->startOfDay())) {
            return response()->json(['slots' => [], 'error' => 'Date is in the past']);
        }

        // Check citizen doesn't already have an appointment this day
        $existing = Appointment::where('citizen_id', Auth::id())
            ->where('date', $date)
            ->whereNotIn('status', ['cancelled'])
            ->first();

        if ($existing) {
            return response()->json([
                'slots'   => [],
                'error'   => 'You already have an appointment on this day',
                'existing' => [
                    'time_slot' => $existing->time_slot,
                    'status'    => $existing->status,
                ],
            ]);
        }

        $available = Appointment::availableSlotsForDate($date);

        return response()->json(['slots' => $available]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'date'      => 'required|date|after_or_equal:today',
            'time_slot' => 'required|in:09:00,10:00,11:00,12:00,13:00',
            'notes'     => 'nullable|string|max:500',
        ]);

        if (OffDay::isOffDay($request->date)) {
            return back()->with('error', 'That date is an off day. Please choose another.');
        }

        // Check slot is still available (race condition guard)
        $taken = Appointment::where('date', $request->date)
            ->where('time_slot', $request->time_slot)
            ->whereNotIn('status', ['cancelled'])
            ->exists();

        if ($taken) {
            return back()->with('error', 'That time slot was just taken. Please choose another.');
        }

        // Citizen can only have one active appointment per day
        $alreadyBooked = Appointment::where('citizen_id', Auth::id())
            ->where('date', $request->date)
            ->whereNotIn('status', ['cancelled'])
            ->exists();

        if ($alreadyBooked) {
            return back()->with('error', 'You already have an appointment on that day.');
        }

        Appointment::create([
            'citizen_id' => Auth::id(),
            'date'       => $request->date,
            'time_slot'  => $request->time_slot,
            'notes'      => $request->notes,
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
