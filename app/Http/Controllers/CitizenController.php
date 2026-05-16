<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CitizenController extends Controller
{
    public function index()
    {
        $applications = auth()->user()
            ->applications()
            ->with(['appointment', 'documents'])
            ->latest()
            ->get();

        return view('citizen.dashboard', compact('applications'));
    }
}
