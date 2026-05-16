<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Application;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ApplicationController extends Controller
{
    public function showQrReceipt($id)
    {
        $application = Application::with('user')->findOrFail($id);

        if ($application->user_id !== auth()->id()) {
            abort(403);
        }

        return view('citizen.qr-receipt', compact('application'));
    }

    public function downloadPdf($id)
    {
        $application = Application::with('user')->findOrFail($id);

        if ($application->user_id !== auth()->id()) {
            abort(403);
        }

        $url = url('/track/' . $application->tracking_code);
        $qrBase64 = base64_encode(QrCode::format('png')->size(200)->generate($url));

        $pdf = Pdf::loadView('citizen.qr-pdf', compact('application', 'qrBase64'));
        return $pdf->download('Receipt-' . $application->tracking_code . '.pdf');
    }
}
