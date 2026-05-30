<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Ministry;
use Illuminate\Support\Facades\Auth;

class CitizenController extends Controller
{
    public function index()
    {
        $upcomingAppointments = Auth::user()->appointments()
            ->with('service.ministry')
            ->where('date', '>=', now()->toDateString())
            ->whereNotIn('status', ['cancelled'])
            ->orderBy('date')->orderBy('time_slot')
            ->take(5)
            ->get();

        $recentApplications = Application::with(['service.ministry', 'appointment'])
            ->where('user_id', Auth::id())
            ->latest()
            ->take(4)
            ->get();

        $doneStatuses = ['completed', 'collected', 'connected'];

        $appStats = [
            'total'    => Application::where('user_id', Auth::id())->count(),
            'active'   => Application::where('user_id', Auth::id())
                            ->whereNotIn('current_status', array_merge($doneStatuses, ['rejected']))
                            ->count(),
            'done'     => Application::where('user_id', Auth::id())
                            ->whereIn('current_status', $doneStatuses)
                            ->count(),
            'upcoming' => Auth::user()->appointments()
                            ->where('date', '>=', now()->toDateString())
                            ->whereNotIn('status', ['cancelled'])
                            ->count(),
        ];

        $ministries = Ministry::with('activeServices')->orderBy('order')->get();

        return view('citizen.dashboard', compact(
            'upcomingAppointments', 'recentApplications', 'appStats', 'ministries'
        ));
    }
}
