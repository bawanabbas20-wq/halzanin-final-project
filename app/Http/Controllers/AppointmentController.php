<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Document;

class AppointmentController extends Controller
{
    /**
     * Required documents per document type.
     * Key = input field name, Value = human-readable label
     */
    public static function requiredDocs(string $docType): array
    {
        return match ($docType) {
            'Passport Renewal' => [
                'doc_current_passport' => 'Current Passport (scan/photo)',
                'doc_national_id'      => 'National ID',
                'doc_passport_photo'   => 'Passport-size Photo',
                'doc_fee_receipt'      => 'Fee Receipt',
            ],
            'New Passport' => [
                'doc_birth_certificate' => 'Birth Certificate',
                'doc_national_id'       => 'National ID',
                'doc_passport_photo'    => 'Passport-size Photo',
            ],
            'ID Card' => [
                'doc_birth_certificate' => 'Birth Certificate',
                'doc_national_id'       => 'National ID',
                'doc_passport_photo'    => 'Passport-size Photo',
            ],
            'Birth Certificate' => [
                'doc_hospital_record'   => 'Hospital Birth Record',
                'doc_parent_national_id'=> "Parent's National ID",
            ],
            default => [ // 'Other'
                'doc_national_id' => 'National ID',
            ],
        };
    }

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
        // --- Step 1 & 2 validation ---
        $validated = $request->validate([
            'full_name'          => 'required|string|max:255',
            'national_id_number' => 'required|string|max:255',
            'preferred_date'     => 'required|date|after_or_equal:today',
            'time_slot'          => 'required|string',
            'document_type'      => 'required|string',
            'notes'              => 'nullable|string',
        ]);

        // --- Step 3: validate required documents for the chosen type ---
        $docType  = $request->input('document_type');
        $required = self::requiredDocs($docType);
        $fileRules = [];
        foreach ($required as $inputName => $label) {
            $fileRules[$inputName] = 'required|file|mimes:jpg,jpeg,png,pdf|max:5120';
        }
        $request->validate($fileRules);

        // --- Create appointment ---
        $validated['user_id'] = auth()->id();
        $validated['status']  = 'pending';
        $appointment = Appointment::create($validated);

        // --- Generate tracking code ---
        do {
            $code = 'TRK-' . strtoupper(\Illuminate\Support\Str::random(8));
        } while (\App\Models\Application::where('tracking_code', $code)->exists());

        // --- Create application ---
        $application = \App\Models\Application::create([
            'user_id'        => auth()->id(),
            'appointment_id' => $appointment->id,
            'tracking_code'  => $code,
            'current_status' => 'submitted',
            'submitted_at'   => now(),
        ]);

        // --- Log initial status ---
        \App\Models\StatusLog::create([
            'application_id' => $application->id,
            'status'         => 'submitted',
            'changed_by'     => auth()->id(),
            'notes'          => 'Application submitted by citizen',
        ]);

        // --- Store uploaded documents ---
        $userId = auth()->id();
        foreach ($required as $inputName => $label) {
            if ($request->hasFile($inputName)) {
                $file     = $request->file($inputName);
                $filename = $label . '_' . time() . '_' . $file->getClientOriginalName();
                $path     = $file->storeAs("documents/{$userId}", $filename);

                Document::create([
                    'application_id' => $application->id,
                    'doc_type'       => $label,
                    'file_path'      => $path,
                    'original_name'  => $file->getClientOriginalName(),
                    'file_size'      => $file->getSize(),
                    'is_verified'    => false,
                ]);
            }
        }

        session()->forget('appointment_draft');

        return redirect()->route('citizen.applications.qr-receipt', $application->id)
            ->with('success', 'Your appointment has been booked and documents uploaded successfully!');
    }
}
