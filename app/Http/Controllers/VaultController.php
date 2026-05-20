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
            // SECURITY: max:7000000 chars ≈ 5 MB decoded; prevents oversized base64 payloads
            'image'         => 'required|string|max:7000000',
            'document_type' => 'required|string|in:Passport,National ID,Driver License,Other',
            'side'          => 'nullable|string|in:front,back',
            'vault_id'      => 'nullable|integer|min:1',
        ]);

        $imageData = $request->input('image');
        if (preg_match('/^data:image\/(\w+);base64,/', $imageData, $type)) {
            $imageData = substr($imageData, strpos($imageData, ',') + 1);
            $type = strtolower($type[1]);
            if (!in_array($type, ['jpg', 'jpeg', 'png'])) {
                return response()->json(['error' => 'Invalid image type'], 400);
            }
            $imageData = base64_decode($imageData);
        } else {
            return response()->json(['error' => 'Invalid image data'], 400);
        }

        $userId   = auth()->id();
        $fileName = (string) Str::uuid();
        $side     = $request->input('side', 'front');

        Storage::makeDirectory('vault/' . $userId);

        $imagePath = 'vault/' . $userId . '/' . $fileName . '.' . $type;
        $pdfPath   = 'vault/' . $userId . '/' . $fileName . '.pdf';

        Storage::put($imagePath, Crypt::encrypt($imageData));

        $base64ForPdf = 'data:image/' . $type . ';base64,' . base64_encode($imageData);
        $pdf = Pdf::loadView('pdf.vault-document', ['image' => $base64ForPdf, 'type' => $request->document_type]);
        Storage::put($pdfPath, Crypt::encrypt($pdf->output()));

        // Back-side: update existing record
        if ($side === 'back' && $request->filled('vault_id')) {
            $document = auth()->user()->vaultDocuments()->findOrFail($request->vault_id);
            $document->update([
                'back_image_path' => $imagePath,
                'back_pdf_path'   => $pdfPath,
            ]);
            return response()->json(['success' => true, 'redirect' => route('citizen.vault.index')]);
        }

        // Front-side: create new record
        $document = VaultDocument::create([
            'user_id'               => $userId,
            'document_type'         => $request->document_type,
            'original_name'         => $request->document_type . ' Scan',
            'encrypted_image_path'  => $imagePath,
            'encrypted_pdf_path'    => $pdfPath,
            'expires_at'            => now()->addDays(100),
        ]);

        return response()->json([
            'success'  => true,
            'vault_id' => $document->id,
            'redirect' => route('citizen.vault.index'),
        ]);
    }

    public function viewFile($document, $format = 'pdf')
    {
        $doc = auth()->user()->vaultDocuments()->findOrFail($document);

        $path = $format === 'pdf' ? $doc->encrypted_pdf_path : $doc->encrypted_image_path;

        if (!$path || !Storage::exists($path)) {
            abort(404);
        }

        try {
            $decryptedContent = Crypt::decrypt(Storage::get($path));
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            abort(500, 'Could not decrypt file.');
        }

        $mimeType  = $format === 'pdf' ? 'application/pdf' : 'image/jpeg';
        $extension = $format === 'pdf' ? 'pdf' : 'jpg';

        return response($decryptedContent, 200, [
            'Content-Type'        => $mimeType,
            'Content-Disposition' => 'inline; filename="' . $doc->original_name . '.' . $extension . '"',
        ]);
    }

    public function destroy($document)
    {
        $doc = auth()->user()->vaultDocuments()->findOrFail($document);

        foreach ([$doc->encrypted_image_path, $doc->encrypted_pdf_path, $doc->back_image_path, $doc->back_pdf_path] as $path) {
            if ($path && Storage::exists($path)) {
                Storage::delete($path);
            }
        }

        $doc->delete();

        return redirect()->route('citizen.vault.index')->with('success', 'Document removed securely.');
    }
}
