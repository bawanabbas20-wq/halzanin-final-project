<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Application;
use App\Models\StatusLog;
use App\Notifications\ApplicationStatusChanged;
use App\Services\WhatsAppService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ApplicationController extends Controller
{
    private const NEXT_STATUSES = [
        'submitted'    => ['under_review' => 'Move to Review'],
        'under_review' => ['approved' => 'Approve', 'rejected' => 'Reject'],
    ];

    public function index()
    {
        $applications = Application::with([
            'appointment',
            'statusLogs' => fn ($query) => $query->latest(),
        ])
            ->where('user_id', Auth::id())
            ->latest('submitted_at')
            ->latest()
            ->get();

        return view('citizen.my-applications', compact('applications'));
    }

    public function queue()
    {
        $applications = Application::with(['user', 'appointment'])
            ->latest()
            ->paginate(15);

        return view('staff.queue', compact('applications'));
    }

    public function show(Application $application)
    {
        $application->load([
            'user',
            'appointment',
            'documents.vaultDocument',
            'statusLogs' => fn ($query) => $query->oldest(),
        ]);

        $nextStatuses = self::NEXT_STATUSES[$application->current_status] ?? [];

        return view('staff.application', compact('application', 'nextStatuses'));
    }

    public function updateStatus(Request $request, Application $application, WhatsAppService $whatsApp)
    {
        $allowedNextStatuses = array_keys(self::NEXT_STATUSES[$application->current_status] ?? []);

        $request->validate([
            'new_status' => ['required', 'in:' . implode(',', $allowedNextStatuses)],
            'notes'      => [$request->new_status === 'rejected' ? 'required' : 'nullable', 'string', 'max:1000'],
        ]);

        $application->update([
            'current_status' => $request->new_status,
        ]);

        StatusLog::create([
            'application_id' => $application->id,
            'status'         => $request->new_status,
            'changed_by'     => Auth::id(),
            'notes'          => $request->notes,
        ]);

        $application->loadMissing(['user', 'appointment']);
        $application->user?->notify(new ApplicationStatusChanged($application));

        if (in_array($request->new_status, ['approved', 'rejected'], true) && filled($application->user?->phone_number)) {
            $status = str_replace('_', ' ', $request->new_status);
            $whatsApp->send(
                $application->user->phone_number,
                "Your Halzanin application {$application->tracking_code} has been {$status}. Track it here: " . url('/track/' . $application->tracking_code)
            );
        }

        return redirect()->route('staff.applications.show', $application)
            ->with('success', 'Application status updated successfully.');
    }

    public function showQrReceipt($id)
    {
        $application = Application::with(['user', 'appointment'])->findOrFail($id);

        if ($application->user_id !== auth()->id()) {
            abort(403);
        }

        return view('citizen.qr-receipt', compact('application'));
    }

    public function downloadPdf($id)
    {
        $application = Application::with(['user', 'appointment'])->findOrFail($id);

        if ($application->user_id !== auth()->id()) {
            abort(403);
        }

        $url = url('/track/' . $application->tracking_code);
        $qrSvg = QrCode::format('svg')->size(200)->generate($url);
        $qrBase64 = base64_encode($qrSvg);

        $pdf = Pdf::loadView('citizen.qr-pdf', compact('application', 'qrBase64'));
        return $pdf->download('Receipt-' . $application->tracking_code . '.pdf');
    }
}
