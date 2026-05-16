<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Appointment;

class AppointmentController extends Controller
{
    public function create()
    {
        return view('citizen.appointment');
    }

    public function saveDraft(Request $request)
    {
        session(['appointment_draft' => $request->all()]);
        return response()->json(['success' => true]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'national_id_number' => 'required|string|max:255',
            'preferred_date' => 'required|date|after_or_equal:today',
            'time_slot' => 'required|string',
            'document_type' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['status'] = 'pending';

        $appointment = Appointment::create($validated);

        do {
            $code = 'TRK-' . strtoupper(\Illuminate\Support\Str::random(8));
        } while (\App\Models\Application::where('tracking_code', $code)->exists());

        $application = \App\Models\Application::create([
            'user_id' => auth()->id(),
            'appointment_id' => $appointment->id,
            'tracking_code' => $code,
            'current_status' => 'submitted',
            'submitted_at' => now(),
        ]);

        \App\Models\StatusLog::create([
            'application_id' => $application->id,
            'status' => 'submitted',
            'changed_by' => auth()->id(),
            'notes' => 'Application submitted by citizen',
        ]);

        session()->forget('appointment_draft');

        return redirect()->route('citizen.applications.qr-receipt', $application->id)->with('success', 'Your appointment has been booked successfully!');
    }
}
