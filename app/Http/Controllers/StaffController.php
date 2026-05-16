<?php

namespace App\Http\Controllers;

use App\Mail\StatusUpdatedMail;
use App\Models\Application;
use App\Models\StatusLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class StaffController extends Controller
{
    // Valid status transition order
    protected array $statusOrder = [
        'submitted'    => 0,
        'received'     => 1,
        'under_review' => 2,
        'approved'     => 3,
        'rejected'     => 3, // same level as approved — both terminal
    ];

    public function index()
    {
        $applications = Application::with(['appointment', 'user'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('staff.queue', compact('applications'));
    }

    public function show($id)
    {
        $application = Application::with([
            'appointment',
            'user',
            'statusLogs' => fn($q) => $q->orderBy('created_at', 'asc'),
        ])->findOrFail($id);

        $nextStatuses = $this->getNextStatuses($application->current_status);

        return view('staff.application', compact('application', 'nextStatuses'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'new_status' => 'required|in:received,under_review,approved,rejected',
            'notes'      => 'nullable|string',
        ]);

        $application = Application::with('user', 'appointment')->findOrFail($id);

        // Enforce forward-only transitions
        $current  = $application->current_status;
        $next     = $request->new_status;
        $validNext = $this->getNextStatuses($current);

        if (!in_array($next, array_keys($validNext))) {
            return back()->withErrors(['new_status' => 'Invalid status transition.'])->withInput();
        }

        // Update status
        $application->current_status = $next;
        $application->save();

        // Log the change
        StatusLog::create([
            'application_id' => $application->id,
            'status'         => $next,
            'changed_by'     => auth()->id(),
            'notes'          => $request->notes,
        ]);

        // Send email notification (fail-safe)
        try {
            Mail::to($application->user->email)->send(new StatusUpdatedMail($application));
        } catch (\Throwable $e) {
            // Mail failure is non-fatal — log and continue
            \Log::error('StatusUpdatedMail failed: ' . $e->getMessage());
        }

        return redirect()
            ->route('staff.applications.show', $application->id)
            ->with('success', 'Status updated to "' . str_replace('_', ' ', $next) . '" successfully.');
    }

    protected function getNextStatuses(string $current): array
    {
        $terminal = ['approved', 'rejected'];

        // If already terminal, no further moves
        if (in_array($current, $terminal)) {
            return [];
        }

        $currentLevel = $this->statusOrder[$current] ?? 0;

        $all = [
            'received'     => 'Received',
            'under_review' => 'Under Review',
            'approved'     => 'Approved',
            'rejected'     => 'Rejected',
        ];

        return array_filter($all, function ($label, $key) use ($currentLevel) {
            return ($this->statusOrder[$key] ?? 0) > $currentLevel;
        }, ARRAY_FILTER_USE_BOTH);
    }
}
