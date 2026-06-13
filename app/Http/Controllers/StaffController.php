<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Application;
use App\Models\Document;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function index()
    {
        $user     = auth()->user();
        $ministry = $user->ministry;

        $base = Application::query();

        if ($ministry) {
            $base->where(function ($q) use ($ministry) {
                $q->whereHas('service', fn ($sq) => $sq->where('ministry_id', $ministry->id))
                  ->orWhereNull('service_id');
            });
        }

        $doneStatuses    = ['approved', 'rejected', 'completed', 'collected', 'connected'];
        $pendingStatuses = ['submitted', 'received'];

        $stats = [
            'total'     => (clone $base)->count(),
            'pending'   => (clone $base)->whereIn('current_status', $pendingStatuses)->count(),
            // "Reviewing" = anything actively in progress (any status that is not a
            // brand-new submission nor a finished outcome). This works across every
            // per-service flow, not just the legacy "under_review" status.
            'reviewing' => (clone $base)->whereNotIn('current_status', array_merge($pendingStatuses, $doneStatuses))->count(),
            'completed' => (clone $base)->whereIn('current_status', $doneStatuses)->count(),
        ];

        return view('staff.dashboard', compact('ministry', 'stats'));
    }

    public function calendar(Request $request)
    {
        return redirect()->route('staff.queue', [
            'view'  => 'calendar',
            'year'  => $request->get('year', now()->year),
            'month' => $request->get('month', now()->month),
        ]);
    }

    public function dayAppointments(Request $request)
    {
        $request->validate(['date' => 'required|date_format:Y-m-d']);

        $date = $request->get('date');
        $user = auth()->user();

        $query = Appointment::with(['citizen', 'documents.vaultDocument', 'service.ministry'])
            ->where('date', $date)
            ->whereNotIn('status', ['cancelled'])
            ->orderBy('time_slot');

        if ($user->ministry_id) {
            $query->where(function ($q) use ($user) {
                $q->whereHas('service', fn ($sq) => $sq->where('ministry_id', $user->ministry_id))
                  ->orWhereNull('service_id');
            });
        }

        $appointments = $query->get()->map(fn($a) => [
            'id'             => $a->id,
            'time_slot'      => $a->time_slot,
            'status'         => $a->status,
            'citizen'        => $a->citizen->name ?? 'Unknown',
            'full_name'      => $a->full_name,
            'document_type'  => $a->document_type,
            'service_name'   => $a->service?->name,
            'ministry_color' => $a->service?->ministry?->color ?? '#1B4F8A',
            'national_id'    => $a->national_id_number,
            'notes'          => $a->notes,
            'documents'      => $a->documents->map(fn($d) => [
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

    public function viewDocument(Document $document)
    {
        abort_if($document->source !== 'upload' || !$document->file_path, 404);

        $fullPath = storage_path('app/' . $document->file_path);
        abort_unless(file_exists($fullPath), 404);

        return response()->file($fullPath);
    }
}
