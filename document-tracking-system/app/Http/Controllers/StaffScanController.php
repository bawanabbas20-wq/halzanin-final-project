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
        $request->validate(['tracking_code' => 'required|string']);

        $raw = trim($request->tracking_code);

        // Extract TRK-XXXXXXXX from a full URL or bare code
        if (preg_match('/(TRK-[A-Z0-9]+)/i', $raw, $m)) {
            $code = strtoupper($m[1]);
        } else {
            $code = strtoupper($raw);
        }

        $application = Application::with(['appointment', 'user'])
            ->where('tracking_code', $code)
            ->first();

        if (!$application || !$application->appointment) {
            return response()->json(['result' => 'not_found']);
        }

        $today = now()->toDateString();
        if ($application->appointment->date !== $today) {
            return response()->json([
                'result' => 'wrong_date',
                'date'   => \Carbon\Carbon::parse($application->appointment->date)->format('M d, Y'),
            ]);
        }

        if ($application->current_status === 'checked_in') {
            $log = $application->statusLogs()
                ->where('status', 'checked_in')
                ->latest()
                ->first();
            return response()->json([
                'result' => 'already_checked_in',
                'time'   => $log ? $log->created_at->format('h:i A') : 'earlier today',
            ]);
        }

        $application->update(['current_status' => 'checked_in']);

        StatusLog::create([
            'application_id' => $application->id,
            'status'         => 'checked_in',
            'changed_by'     => Auth::id(),
            'notes'          => 'Checked in via QR scanner',
        ]);

        return response()->json([
            'result'        => 'success',
            'name'          => $application->appointment->full_name ?? $application->user->name,
            'document_type' => $application->appointment->document_type ?? '—',
            'time_slot'     => $application->appointment->time_slot ?? '—',
            'tracking_code' => $application->tracking_code,
        ]);
    }
}
