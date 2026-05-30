<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Appointment;
use App\Models\Service;
use App\Models\StatusLog;
use App\Notifications\ApplicationStatusChanged;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    public function show(string $slug)
    {
        $service = Service::with('ministry')->where('slug', $slug)->firstOrFail();
        return view('services.show', compact('service'));
    }

    public function applyForm(string $slug)
    {
        $service = Service::with('ministry')->where('slug', $slug)->where('is_active', true)->firstOrFail();

        return redirect()->route('citizen.appointments.book', [
            'ministry' => $service->ministry->slug,
            'service'  => $service->slug,
        ]);
    }

    public function store(Request $request, string $slug)
    {
        $service = Service::with('ministry')->where('slug', $slug)->where('is_active', true)->firstOrFail();

        $rules = [
            'full_name'         => 'required|string|max:255',
            'national_id_number'=> 'required|string|max:50',
            'appointment_date'  => 'required|date|after_or_equal:today',
            'time_slot'         => 'required|in:' . implode(',', Appointment::TIME_SLOTS),
            'documents.*'       => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ];

        foreach ($service->form_schema ?? [] as $field) {
            if ($field['required'] ?? false) {
                $rules['form.' . $field['name']] = 'required';
            } else {
                $rules['form.' . $field['name']] = 'nullable';
            }
        }

        $validated = $request->validate($rules);

        DB::transaction(function () use ($request, $service, $validated) {
            $appointment = Appointment::create([
                'citizen_id'         => Auth::id(),
                'service_id'         => $service->id,
                'full_name'          => $validated['full_name'],
                'national_id_number' => $validated['national_id_number'],
                'document_type'      => $service->name,
                'date'               => $validated['appointment_date'],
                'time_slot'          => $validated['time_slot'],
                'status'             => 'pending',
            ]);

            if ($request->hasFile('documents')) {
                foreach ($request->file('documents') as $file) {
                    $path = $file->store('documents', 'private');
                    $appointment->documents()->create([
                        'document_name' => $file->getClientOriginalName(),
                        'original_name' => $file->getClientOriginalName(),
                        'file_path'     => $path,
                        'file_size'     => $file->getSize(),
                        'source'        => 'upload',
                    ]);
                }
            }

            $application = Application::create([
                'user_id'        => Auth::id(),
                'appointment_id' => $appointment->id,
                'service_id'     => $service->id,
                'form_data'      => $request->input('form', []),
                'tracking_code'  => 'HZ-' . strtoupper(Str::random(8)),
                'current_status' => 'submitted',
                'submitted_at'   => now(),
            ]);

            StatusLog::create([
                'application_id' => $application->id,
                'status'         => 'submitted',
                'changed_by'     => Auth::id(),
                'notes'          => 'Application submitted online.',
            ]);

            Auth::user()->notify(new ApplicationStatusChanged($application));

            session(['new_application_id' => $application->id]);
        });

        return redirect()->route('citizen.applications.index')
            ->with('success', 'Your application has been submitted. Check your email for your tracking code.');
    }

    private function getAvailableDates(): array
    {
        $dates = [];
        $day   = now()->addDay();
        $limit = now()->addDays(30);

        while ($day->lte($limit) && count($dates) < 20) {
            if (!$day->isWeekend()) {
                if (Appointment::bookingCountForDate($day->toDateString()) < (Appointment::MAX_SLOTS_PER_DAY * 3)) {
                    $dates[] = $day->toDateString();
                }
            }
            $day->addDay();
        }

        return $dates;
    }
}
