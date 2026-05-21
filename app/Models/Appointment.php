<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'citizen_id',
        'service_id',
        'full_name',
        'national_id_number',
        'document_type',
        'date',
        'time_slot',
        'status',
        'notes',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public const TIME_SLOTS = ['09:00', '10:00', '11:00', '12:00', '13:00'];
    public const MAX_SLOTS_PER_DAY = 5;

    public function citizen()
    {
        return $this->belongsTo(User::class, 'citizen_id');
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function application()
    {
        return $this->hasOne(Application::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public static function bookedSlotsForDate(string $date): array
    {
        return self::where('date', $date)
            ->whereNotIn('status', ['cancelled'])
            ->pluck('time_slot')
            ->toArray();
    }

    public static function availableSlotsForDate(string $date): array
    {
        $booked = self::bookedSlotsForDate($date);
        return array_values(array_diff(self::TIME_SLOTS, $booked));
    }

    public static function bookingCountForDate(string $date): int
    {
        return self::where('date', $date)
            ->whereNotIn('status', ['cancelled'])
            ->count();
    }
}
