<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Document;
use App\Models\OffDay;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function index()
    {
        return view('staff.dashboard');
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

        $appointments = Appointment::with(['citizen', 'documents.vaultDocument'])
            ->where('date', $date)
            ->whereNotIn('status', ['cancelled'])
            ->orderBy('time_slot')
            ->get()
            ->map(fn($a) => [
                'id'            => $a->id,
                'time_slot'     => $a->time_slot,
                'status'        => $a->status,
                'citizen'       => $a->citizen->name ?? 'Unknown',
                'full_name'     => $a->full_name,
                'document_type' => $a->document_type,
                'national_id'   => $a->national_id_number,
                'notes'         => $a->notes,
                'documents'     => $a->documents->map(fn($d) => [
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
