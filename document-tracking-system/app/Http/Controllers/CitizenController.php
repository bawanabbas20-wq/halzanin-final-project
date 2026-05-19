<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CitizenController extends Controller
{
    public function index()
    {
        $upcomingAppointments = Auth::user()->appointments()
            ->with('application')
            ->where('date', '>=', now()->toDateString())
            ->whereNotIn('status', ['cancelled'])
            ->orderBy('date')->orderBy('time_slot')
            ->take(5)
            ->get();

        return view('citizen.dashboard', compact('upcomingAppointments'));
    }

    public function myApplications()
    {
        $applications = Application::where('user_id', Auth::id())
            ->with([
                'appointment',
                'statusLogs' => fn($q) => $q->latest()->limit(1),
            ])
            ->latest()
            ->get();

        return view('citizen.my-applications', compact('applications'));
    }

    public function qrReceipt(Application $application)
    {
        if ($application->user_id !== Auth::id()) {
            abort(403);
        }

        $application->load('appointment');

        return view('citizen.qr-receipt', compact('application'));
    }
}
