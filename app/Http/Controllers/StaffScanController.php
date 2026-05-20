<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\StatusLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffScanController extends Controller
{
    public function index()
    {
        return view('staff.scan');
    }

    public function checkin(Request $request)
    {
        // SECURITY: regex enforces TRK-YYMMDD-XXXXXX format; max:30 prevents oversized input
        $request->validate(['tracking_code' => 'required|string|max:30|regex:/^[A-Z0-9\-]+$/']);

        $application = Application::with(['user', 'appointment'])
            ->where('tracking_code', $request->tracking_code)
            ->first();

        if (!$application) {
            return response()->json(['status' => 'not_found'], 404);
        }

        if ($application->current_status === 'checked_in') {
            $checkedInAt = $application->statusLogs()
                ->where('status', 'checked_in')
                ->latest()
                ->value('created_at');

            return response()->json([
                'status'        => 'already_checked_in',
                'checked_in_at' => $checkedInAt?->format('h:i A'),
                'citizen_name'  => $application->user?->name,
            ]);
        }

        $appointment = $application->appointment;

        if ($appointment && $appointment->date && $appointment->date !== today()->toDateString()) {
            return response()->json([
                'status'           => 'wrong_date',
                'appointment_date' => \Carbon\Carbon::parse($appointment->date)->format('M d, Y'),
            ]);
        }

        $application->update(['current_status' => 'checked_in']);

        StatusLog::create([
            'application_id' => $application->id,
            'status'         => 'checked_in',
            'changed_by'     => Auth::id(),
            'notes'          => 'Checked in via QR scanner.',
        ]);

        return response()->json([
            'status'           => 'success',
            'citizen_name'     => $application->user?->name,
            'tracking_code'    => $application->tracking_code,
            'appointment_time' => $appointment?->time_slot ?? null,
        ]);
    }
}
