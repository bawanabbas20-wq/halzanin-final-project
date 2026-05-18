<?php

namespace App\Console\Commands;

use App\Models\VaultDocument;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CleanupVault extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vault:cleanup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deletes expired documents from the Document Vault securely.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $expiredDocuments = VaultDocument::where('expires_at', '<=', now())->get();
        $count = 0;

        foreach ($expiredDocuments as $document) {
            // Delete physical encrypted files
            if (Storage::exists($document->encrypted_image_path)) {
                Storage::delete($document->encrypted_image_path);
            }
            if ($document->encrypted_pdf_path && Storage::exists($document->encrypted_pdf_path)) {
                Storage::delete($document->encrypted_pdf_path);
            }

            // Delete database record
            $document->delete();
            $count++;
        }

        $this->info("Securely deleted $count expired document(s) from the vault.");
    }
}
