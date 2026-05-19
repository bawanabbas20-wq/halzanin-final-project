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
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public static function isOffDay(string $date): bool
    {
        $dayOfWeek = date('N', strtotime($date)); // 1=Mon, 5=Fri, 6=Sat
        if (in_array($dayOfWeek, [5, 6])) {
            return true;
        }
        return self::where('date', $date)->exists();
    }

    public static function offDatesForMonth(int $year, int $month): array
    {
        return self::whereYear('date', $year)
            ->whereMonth('date', $month)
            ->pluck('date')
            ->map(fn($d) => $d->format('Y-m-d'))
            ->toArray();
    }
}
