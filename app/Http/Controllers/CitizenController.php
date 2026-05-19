<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CitizenController extends Controller
{
    public function index()
    {
        $upcomingAppointments = Auth::user()->appointments()
            ->where('date', '>=', now()->toDateString())
            ->whereNotIn('status', ['cancelled'])
            ->orderBy('date')->orderBy('time_slot')
            ->take(5)
            ->get();

        return view('citizen.dashboard', compact('upcomingAppointments'));
    }
}
