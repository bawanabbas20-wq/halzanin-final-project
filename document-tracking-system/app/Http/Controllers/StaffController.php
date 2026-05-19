<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\OffDay;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function index()
    {
        return view('staff.dashboard');
    }

    public function calendar(Request $request)
    {
        $year  = (int) $request->get('year', now()->year);
        $month = (int) $request->get('month', now()->month);

        $current = Carbon::createFromDate($year, $month, 1);

        $year  = $current->year;
        $month = $current->month;

        // Per-day booking counts
        $counts = Appointment::where('date', 'like', $current->format('Y-m') . '-%')
            ->whereNotIn('status', ['cancelled'])
            ->selectRaw('date, COUNT(*) as count')
            ->groupBy('date')
            ->pluck('count', 'date')
            ->toArray();

        $offDates = OffDay::offDatesForMonth($year, $month);

        return view('staff.calendar', compact('year', 'month', 'current', 'counts', 'offDates'));
    }

    public function dayAppointments(Request $request)
    {
        $date = $request->get('date');

        $appointments = Appointment::with('citizen')
            ->where('date', $date)
            ->whereNotIn('status', ['cancelled'])
            ->orderBy('time_slot')
            ->get()
            ->map(fn($a) => [
                'id'         => $a->id,
                'time_slot'  => $a->time_slot,
                'status'     => $a->status,
                'citizen'    => $a->citizen->name ?? 'Unknown',
                'notes'      => $a->notes,
            ]);

        return response()->json(['appointments' => $appointments]);
    }

    public function updateStatus(Request $request, Appointment $appointment)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled',
        ]);

        $appointment->update(['status' => $request->status]);

        return response()->json(['success' => true, 'status' => $appointment->status]);
    }
}
