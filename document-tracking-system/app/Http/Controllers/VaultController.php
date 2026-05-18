<?php

namespace App\Http\Controllers;

use App\Models\VaultDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class VaultController extends Controller
{
    public function index()
    {
        $documents = auth()->user()->vaultDocuments()->orderBy('created_at', 'desc')->get();
        return view('citizen.vault.index', compact('documents'));
    }

    public function scan()
    {
        return view('citizen.vault.scan');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|string',
            'document_type' => 'required|string|in:Passport,National ID,Driver License,Other',
        ]);

        $imageData = $request->input('image');
        // $imageData is likely a base64 string from canvas
        if (preg_match('/^data:image\/(\w+);base64,/', $imageData, $type)) {
            $imageData = substr($imageData, strpos($imageData, ',') + 1);
            $type = strtolower($type[1]); // jpg, png, gif

            if (!in_array($type, ['jpg', 'jpeg', 'png'])) {
                return response()->json(['error' => 'Invalid image type'], 400);
            }
            $imageData = base64_decode($imageData);
        } else {
            return response()->json(['error' => 'Invalid image data'], 400);
        }

        $userId = auth()->id();
        $fileName = (string) Str::uuid();
        
        $imagePath = 'vault/' . $userId . '/' . $fileName . '.' . $type;
        $pdfPath = 'vault/' . $userId . '/' . $fileName . '.pdf';

        // Ensure directory exists
        Storage::makeDirectory('vault/' . $userId);

        // Encrypt and save image
        $encryptedImage = Crypt::encrypt($imageData);
        Storage::put($imagePath, $encryptedImage);

        // Generate PDF
        $base64ForPdf = 'data:image/' . $type . ';base64,' . base64_encode($imageData);
        $pdf = Pdf::loadView('pdf.vault-document', ['image' => $base64ForPdf, 'type' => $request->document_type]);
        $pdfData = $pdf->output();

        // Encrypt and save PDF
        $encryptedPdf = Crypt::encrypt($pdfData);
        Storage::put($pdfPath, $encryptedPdf);

        // Create database record
        VaultDocument::create([
            'user_id' => $userId,
            'document_type' => $request->document_type,
            'original_name' => $request->document_type . ' Scan',
            'encrypted_image_path' => $imagePath,
            'encrypted_pdf_path' => $pdfPath,
            'expires_at' => now()->addDays(100),
        ]);

        return response()->json(['success' => true, 'redirect' => route('citizen.vault.index')]);
    }

    public function viewFile($id, $format = 'pdf')
    {
        $document = auth()->user()->vaultDocuments()->findOrFail($id);

        $path = $format === 'pdf' ? $document->encrypted_pdf_path : $document->encrypted_image_path;
        
        if (!$path || !Storage::exists($path)) {
            abort(404);
        }

        $encryptedContent = Storage::get($path);
        
        try {
            $decryptedContent = Crypt::decrypt($encryptedContent);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            abort(500, 'Could not decrypt file.');
        }

        $mimeType = $format === 'pdf' ? 'application/pdf' : 'image/jpeg'; // Simplification for image mime

        return response($decryptedContent, 200, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="' . $document->original_name . '.' . ($format === 'pdf' ? 'pdf' : 'jpg') . '"'
        ]);
    }

    public function destroy($id)
    {
        $document = auth()->user()->vaultDocuments()->findOrFail($id);

        if (Storage::exists($document->encrypted_image_path)) {
            Storage::delete($document->encrypted_image_path);
        }
        if ($document->encrypted_pdf_path && Storage::exists($document->encrypted_pdf_path)) {
            Storage::delete($document->encrypted_pdf_path);
        }

        $document->delete();

        return redirect()->route('citizen.vault.index')->with('success', 'Document removed securely.');
    }
}
