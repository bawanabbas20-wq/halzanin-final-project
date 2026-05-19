<?php

namespace App\Http\Controllers;

use App\Models\Application;

class TrackController extends Controller
{
    public function show(?string $code = null)
    {
        $application = null;

        if ($code) {
            $application = Application::with([
                'user',
                'appointment',
                'statusLogs' => fn ($query) => $query->oldest(),
            ])
                ->where('tracking_code', $code)
                ->first();
        }

        return view('track', compact('application'));
    }
}
