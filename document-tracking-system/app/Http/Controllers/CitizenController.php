<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Appointment;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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

    public function downloadReceipt(Application $application)
    {
        if ($application->user_id !== Auth::id()) {
            abort(403);
        }

        $application->load(['appointment', 'user']);

        $url = url('/track/' . $application->tracking_code);
        $qrSvg = QrCode::format('svg')->size(200)->generate($url);
        $qrBase64 = base64_encode($qrSvg);

        $pdf = Pdf::loadView('citizen.qr-pdf', compact('application', 'qrBase64'));

        return $pdf->download('Receipt-' . $application->tracking_code . '.pdf');
    }
}
