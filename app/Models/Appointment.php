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

    /**
     * Booked (non-cancelled) time slots for a date.
     * When service_id is provided, scoped to that service only (Phase 3+).
     */
    public static function bookedSlotsForDate(string $date, ?int $serviceId = null): array
    {
        $query = self::where('date', $date)->whereNotIn('status', ['cancelled']);

        if ($serviceId !== null) {
            $query->where('service_id', $serviceId);
        }

        return $query->pluck('time_slot')->toArray();
    }

    /**
     * Available time slots for a date (complement of booked slots).
     */
    public static function availableSlotsForDate(string $date, ?int $serviceId = null): array
    {
        $booked = self::bookedSlotsForDate($date, $serviceId);
        return array_values(array_diff(self::TIME_SLOTS, $booked));
    }

    /**
     * Count of non-cancelled bookings for a date.
     */
    public static function bookingCountForDate(string $date, ?int $serviceId = null): int
    {
        $query = self::where('date', $date)->whereNotIn('status', ['cancelled']);

        if ($serviceId !== null) {
            $query->where('service_id', $serviceId);
        }

        return $query->count();
    }
}
