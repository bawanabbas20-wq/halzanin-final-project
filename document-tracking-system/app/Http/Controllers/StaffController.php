<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Appointment;
use App\Models\Document;
use App\Models\OffDay;
use App\Models\StatusLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

class StaffController extends Controller
{
    public function index()
    {
        return view('staff.dashboard');
    }

    public function queue(Request $request)
    {
        $applications = Application::with(['user', 'appointment'])
            ->latest()
            ->paginate(20);

        $calYear  = (int) now()->year;
        $calMonth = (int) now()->month;
        $calCurrent = Carbon::createFromDate($calYear, $calMonth, 1);

        $calCounts = Appointment::where('date', 'like', $calCurrent->format('Y-m') . '-%')
            ->whereNotIn('status', ['cancelled'])
            ->selectRaw('date, COUNT(*) as count')
            ->groupBy('date')
            ->pluck('count', 'date')
            ->toArray();

        $calOffDates = OffDay::offDatesForMonth($calYear, $calMonth);

        return view('staff.queue', compact('applications', 'calYear', 'calMonth', 'calCounts', 'calOffDates'));
    }

    public function calendarMonthData(Request $request)
    {
        $year  = (int) $request->get('year', now()->year);
        $month = (int) $request->get('month', now()->month);
        $current = Carbon::createFromDate($year, $month, 1);

        $counts = Appointment::where('date', 'like', $current->format('Y-m') . '-%')
            ->whereNotIn('status', ['cancelled'])
            ->selectRaw('date, COUNT(*) as count')
            ->groupBy('date')
            ->pluck('count', 'date')
            ->toArray();

        $offDates = OffDay::offDatesForMonth($year, $month);

        return response()->json([
            'year'     => $year,
            'month'    => $month,
            'counts'   => $counts,
            'offDates' => $offDates,
        ]);
    }

    public function showApplication(Application $application)
    {
        $application->load(['appointment', 'documents.vaultDocument', 'statusLogs']);

        $transitions = [
            'submitted'    => ['under_review' => 'Under Review'],
            'under_review' => ['approved' => 'Approved', 'rejected' => 'Rejected'],
            'approved'     => [],
            'rejected'     => [],
        ];

        $nextStatuses = $transitions[$application->current_status] ?? [];

        return view('staff.application', compact('application', 'nextStatuses'));
    }

    public function updateApplicationStatus(Request $request, Application $application)
    {
        $request->validate([
            'new_status' => 'required|in:under_review,approved,rejected',
            'notes'      => 'nullable|string|max:1000',
        ]);

        $application->update(['current_status' => $request->new_status]);

        StatusLog::create([
            'application_id' => $application->id,
            'status'         => $request->new_status,
            'changed_by'     => Auth::id(),
            'notes'          => $request->notes ?: null,
        ]);

        return redirect()->route('staff.applications.show', $application->id)
            ->with('success', 'Status updated to ' . str_replace('_', ' ', $request->new_status) . '.');
    }

    public function calendar(Request $request)
    {
        $year  = (int) $request->get('year', now()->year);
        $month = (int) $request->get('month', now()->month);

        $current = Carbon::createFromDate($year, $month, 1);

        $year  = $current->year;
        $month = $current->month;

        // Per-day booking counts
        $counts = Appointment::where('date', 'like', $current->format('Y-m') . '-%')
            ->whereNotIn('status', ['cancelled'])
            ->selectRaw('date, COUNT(*) as count')
            ->groupBy('date')
            ->pluck('count', 'date')
            ->toArray();

        $offDates = OffDay::offDatesForMonth($year, $month);

        return view('staff.calendar', compact('year', 'month', 'current', 'counts', 'offDates'));
    }

    public function dayAppointments(Request $request)
    {
        $date = $request->get('date');

        $appointments = Appointment::with(['citizen', 'application.documents.vaultDocument'])
            ->where('date', $date)
            ->whereNotIn('status', ['cancelled'])
            ->orderBy('time_slot')
            ->get()
            ->map(fn($a) => [
                'id'            => $a->id,
                'time_slot'     => $a->time_slot,
                'status'        => $a->status,
                'citizen'       => $a->citizen?->name ?? 'Unknown',
                'full_name'     => $a->full_name,
                'document_type' => $a->document_type,
                'national_id'   => $a->national_id_number,
                'notes'         => $a->notes,
                'documents'     => ($a->application?->documents ?? collect())->map(fn($d) => [
                    'id'       => $d->id,
                    'name'     => $d->document_name,
                    'source'   => $d->source,
                    'has_file' => !empty($d->file_path),
                    'label'    => $d->vaultDocument?->original_name ?? $d->original_name,
                ])->values(),
            ]);

        return response()->json(['appointments' => $appointments]);
    }

    public function updateStatus(Request $request, Appointment $appointment)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled',
        ]);

        $appointment->update(['status' => $request->status]);

        return response()->json(['success' => true, 'status' => $appointment->status]);
    }

    public function viewDocument($id)
    {
        $document = Document::with(['application', 'vaultDocument'])->findOrFail($id);

        // Security: staff may only view documents attached to an application.
        abort_unless($document->application()->exists(), 403);

        switch ($document->source) {

            case 'upload':
                abort_unless($document->file_path, 404);

                $path = $document->file_path;
                if (!Storage::disk('local')->exists($path) && Storage::disk('local')->exists('private/' . $path)) {
                    $path = 'private/' . $path;
                }

                abort_unless(Storage::disk('local')->exists($path), 404);

                $content = Storage::disk('local')->get($path);
                $mime = Storage::disk('local')->mimeType($path) ?: 'application/octet-stream';
                $name = $document->original_name ?? basename($document->file_path);

                return response($content, 200, [
                    'Content-Type'        => $mime,
                    'Content-Disposition' => 'inline; filename="' . addslashes($name) . '"',
                ]);

            case 'vault':
                $vault = $document->vaultDocument;
                abort_unless($vault, 404);

                $path = $vault->encrypted_pdf_path ?: $vault->encrypted_image_path;
                $isPdf = (bool) $vault->encrypted_pdf_path;
                abort_unless($path && Storage::disk('local')->exists($path), 404);

                try {
                    $content = Crypt::decrypt(Storage::disk('local')->get($path));
                } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                    abort(500, 'Could not decrypt vault document.');
                }

                $extension = $isPdf ? 'pdf' : 'jpg';
                $mime = $isPdf ? 'application/pdf' : 'image/jpeg';
                $name = ($vault->original_name ?? $document->document_name) . '.' . $extension;

                return response($content, 200, [
                    'Content-Type'        => $mime,
                    'Content-Disposition' => 'inline; filename="' . addslashes($name) . '"',
                ]);

            case 'confirmed':
                return response(
                    '<html><body style="font-family:sans-serif;padding:40px;color:#374151">'
                    . '<h2 style="color:#4338ca">Document Confirmation</h2>'
                    . '<p>The citizen confirmed they will bring <strong>'
                    . e($document->document_name)
                    . '</strong> physically to their appointment.</p>'
                    . '<p style="color:#6b7280;font-size:14px">No file was uploaded — this document will be inspected in person.</p>'
                    . '</body></html>',
                    200,
                    ['Content-Type' => 'text/html']
                );

            default:
                abort(404);
        }
    }
}
