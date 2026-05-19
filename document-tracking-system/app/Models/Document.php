<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'appointment_id',
        'document_name',
        'source',
        'vault_document_id',
        'file_path',
        'original_name',
        'file_size',
        'is_verified',
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function vaultDocument()
    {
        return $this->belongsTo(VaultDocument::class);
    }
}
