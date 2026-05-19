<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'appointment_id',
        'tracking_code',
        'current_status',
        'submitted_at',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class, 'appointment_id', 'appointment_id');
    }

    public function statusLogs()
    {
        return $this->hasMany(StatusLog::class);
    }
}
