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
        'service_id',
        'form_data',
        'tracking_code',
        'current_status',
        'submitted_at',
        'assigned_to',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'form_data'    => 'array',
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

    public function assignedStaff()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
