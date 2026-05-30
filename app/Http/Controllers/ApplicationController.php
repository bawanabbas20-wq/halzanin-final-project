<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Application;
use App\Models\Appointment;
use App\Models\OffDay;
use App\Models\StatusLog;
use App\Notifications\ApplicationStatusChanged;
use App\Services\WhatsAppService;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ApplicationController extends Controller
{
    // Used for the legacy passport flow (no service_id)
    private const PASSPORT_NEXT_STATUSES = [
        'submitted'    => ['under_review' => 'Move to Review'],
        'under_review' => ['approved' => 'Approve', 'rejected' => 'Reject'],
        'checked_in'   => ['under_review' => 'Move to Review'],
    ];

    private function resolveNextStatuses(Application $application): array
    {
        if ($application->service_id && $application->service) {
            return $application->service->allowedNextStatuses($application->current_status);
        }
        return self::PASSPORT_NEXT_STATUSES[$application->current_status] ?? [];
    }

    public function index()
    {
        $applications = Application::with([
            'appointment',
            'service.ministry',
            'statusLogs' => fn ($query) => $query->latest(),
        ])
            ->where('user_id', Auth::id())
            ->latest('submitted_at')
            ->latest()
            ->get();

        return view('citizen.my-applications', compact('applications'));
    }

    public function queue(Request $request)
    {
        $user  = Auth::user();
        $query = Application::with(['user', 'appointment', 'service.ministry']);

        // Ministry-scoped staff only see their ministry's applications
        if ($user->role === 'staff' && $user->ministry_id) {
            $query->whereHas('service', fn ($q) => $q->where('ministry_id', $user->ministry_id))
                  ->orWhereHas('appointment', fn ($q) => $q->whereNull('service_id'));
            // For backward-compat: show unassigned (passport) apps to all staff
            $query = Application::with(['user', 'appointment', 'service.ministry'])
                ->where(function ($q) use ($user) {
                    $q->whereHas('service', fn ($sq) => $sq->where('ministry_id', $user->ministry_id))
                      ->orWhereNull('service_id');
                });
        }

        $applications = $query->latest()->paginate(15);

        $year     = (int) $request->get('year', now()->year);
        $month    = (int) $request->get('month', now()->month);
        $current  = Carbon::createFromDate($year, $month, 1);
        $viewMode = $request->get('view') === 'calendar' ? 'calendar' : 'queue';
        $ministry = $user->ministry;

        $countsQuery = Appointment::where('date', 'like', $current->format('Y-m') . '-%')
            ->whereNotIn('status', ['cancelled']);

        if ($ministry) {
            $countsQuery->whereHas('service', fn ($q) => $q->where('ministry_id', $ministry->id));
        }

        $counts   = $countsQuery->selectRaw('date, COUNT(*) as count')
            ->groupBy('date')
            ->pluck('count', 'date')
            ->toArray();

        $offDates = OffDay::offDatesForMonth($current->year, $current->month, $ministry?->id);

        return view('staff.queue', compact('applications', 'current', 'counts', 'offDates', 'viewMode', 'ministry'));
    }

    public function show(Application $application)
    {
        $application->load([
            'user',
            'appointment',
            'service.ministry',
            'documents.vaultDocument',
            'statusLogs' => fn ($query) => $query->oldest(),
        ]);

        $nextStatuses = $this->resolveNextStatuses($application);

        return view('staff.application', compact('application', 'nextStatuses'));
    }

    public function updateStatus(Request $request, Application $application, WhatsAppService $whatsApp)
    {
        $application->loadMissing('service');
        $allowedNextStatuses = array_keys($this->resolveNextStatuses($application));

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

        $application->loadMissing(['user', 'appointment', 'statusLogs']);
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
