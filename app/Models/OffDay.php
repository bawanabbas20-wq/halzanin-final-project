<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OffDay extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'reason',
        'created_by',
        'ministry_id',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function ministry()
    {
        return $this->belongsTo(Ministry::class);
    }

    /**
     * Check if a date is an off day.
     * Fri/Sat are always off. Custom off days match when:
     *   - ministry_id is null (global), OR
     *   - ministry_id matches the given ministry (if provided)
     */
    public static function isOffDay(string $date, ?int $ministryId = null): bool
    {
        $dayOfWeek = date('N', strtotime($date)); // 1=Mon … 5=Fri, 6=Sat
        if (in_array($dayOfWeek, [5, 6])) {
            return true;
        }

        $query = self::where('date', $date);

        if ($ministryId !== null) {
            $query->where(function ($q) use ($ministryId) {
                $q->whereNull('ministry_id')->orWhere('ministry_id', $ministryId);
            });
        } else {
            $query->whereNull('ministry_id');
        }

        return $query->exists();
    }

    /**
     * Return all off dates for a calendar month.
     * Always includes Fri/Sat. Custom dates include globals + ministry-specific if provided.
     */
    public static function offDatesForMonth(int $year, int $month, ?int $ministryId = null): array
    {
        $query = self::whereYear('date', $year)->whereMonth('date', $month);

        if ($ministryId !== null) {
            $query->where(function ($q) use ($ministryId) {
                $q->whereNull('ministry_id')->orWhere('ministry_id', $ministryId);
            });
        } else {
            $query->whereNull('ministry_id');
        }

        return $query->pluck('date')
            ->map(fn($d) => $d->format('Y-m-d'))
            ->toArray();
    }
}
