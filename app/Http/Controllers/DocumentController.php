<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Document;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function create($applicationId)
    {
        $application = Application::with('documents')->findOrFail($applicationId);

        if ($application->user_id !== auth()->id()) {
            abort(403);
        }

        if ($application->documents->count() >= 3) {
            return redirect()->route('citizen.dashboard')
                ->with('info', 'Your documents have already been submitted.');
        }

        return view('citizen.upload', compact('application'));
    }

    public function store(Request $request, $applicationId)
    {
        $application = Application::with('documents')->findOrFail($applicationId);

        if ($application->user_id !== auth()->id()) {
            abort(403);
        }

        if ($application->documents->count() >= 3) {
            return redirect()->route('citizen.dashboard')
                ->with('info', 'Your documents have already been submitted.');
        }

        $request->validate([
            'national_id_file'  => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'passport_photo'    => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'birth_certificate' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $userId = auth()->id();

        $uploads = [
            'national_id_file'  => 'National ID',
            'passport_photo'    => 'Passport Photo',
            'birth_certificate' => 'Birth Certificate',
        ];

        foreach ($uploads as $inputName => $docType) {
            $file     = $request->file($inputName);
            $filename = $docType . '_' . time() . '_' . $file->getClientOriginalName();
            $path     = $file->storeAs("documents/{$userId}", $filename);

            Document::create([
                'application_id' => $application->id,
                'doc_type'       => $docType,
                'file_path'      => $path,
                'is_verified'    => false,
            ]);
        }

        return redirect()->route('citizen.dashboard')
            ->with('success', 'Your documents have been uploaded successfully.');
    }
}

