<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_id',
        'doc_type',
        'file_path',
        'is_verified',
    ];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }
}
