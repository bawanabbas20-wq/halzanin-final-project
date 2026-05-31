<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'ministry_id', 'name', 'name_ku', 'slug', 'description', 'description_ku',
        'is_active', 'required_documents', 'form_schema', 'statuses', 'estimated_days',
    ];

    protected $casts = [
        'is_active'          => 'boolean',
        'required_documents' => 'array',
        'form_schema'        => 'array',
        'statuses'           => 'array',
    ];

    public function ministry()
    {
        return $this->belongsTo(Ministry::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function nextStatus(string $current): ?string
    {
        $statuses = $this->statuses ?? [];
        $index = array_search($current, $statuses);
        if ($index === false || $index >= count($statuses) - 1) {
            return null;
        }
        return $statuses[$index + 1];
    }

    public function allowedNextStatuses(string $current): array
    {
        $statuses = $this->statuses ?? [];
        $next = $this->nextStatus($current);
        $result = [];
        if ($next) {
            $result[$next] = ucwords(str_replace('_', ' ', $next));
        }
        $finalStatus = $statuses ? $statuses[array_key_last($statuses)] : null;
        if ($current !== 'rejected' && $current !== $finalStatus) {
            $result['rejected'] = 'Reject';
        }
        return $result;
    }
}
