<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'ministry_id',
        'phone_number',
        'otp_code',
        'otp_expires_at',
        'gov_id',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (self $user) {
            if (empty($user->gov_id)) {
                $user->gov_id = static::generateUniqueGovId();
            }
        });
    }

    public static function generateUniqueGovId(): string
    {
        do {
            $govId = static::buildGovId();
        } while (static::where('gov_id', $govId)->exists());

        return $govId;
    }

    private static function buildGovId(): string
    {
        // Alphabet excludes visually ambiguous chars: 0, 1, I, O
        $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
        $len   = strlen($chars);
        $p1    = $p2 = '';
        for ($i = 0; $i < 8; $i++) $p1 .= $chars[random_int(0, $len - 1)];
        for ($i = 0; $i < 4; $i++) $p2 .= $chars[random_int(0, $len - 1)];
        return 'KRG-' . $p1 . '-' . $p2;
    }

    /**
     * Build the HMAC-signed QR payload for this user.
     * Format: HALZANIN:{gov_id}:{user_id}:{hmac16}
     * The HMAC makes the payload tamper-proof and verifiable server-side.
     */
    public function qrPayload(): string
    {
        $sig = substr(
            hash_hmac('sha256', $this->gov_id . '|' . $this->id, config('app.key')),
            0, 16
        );
        return implode(':', ['HALZANIN', $this->gov_id, $this->id, $sig]);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'otp_expires_at'    => 'datetime',
        'password'          => 'hashed',
    ];

    public function taskTypes()
    {
        return $this->belongsToMany(TaskType::class, 'staff_task_type');
    }

    public function subRoles()
    {
        return $this->belongsToMany(SubRole::class, 'user_sub_roles')
            ->withPivot('assigned_by')
            ->withTimestamps();
    }

    public function hasPermission(string $permission): bool
    {
        if (in_array($this->role, ['admin', 'ministry_admin'])) {
            return true;
        }
        if ($this->role === 'staff') {
            $subRoles = $this->relationLoaded('subRoles') ? $this->subRoles : $this->subRoles()->with('permissions')->get();
            if ($subRoles->isEmpty()) {
                return true; // backward-compatible: staff with no sub-roles can do everything
            }
            return $subRoles->contains(fn($sr) => $sr->hasPermission($permission));
        }
        return false;
    }

    public function assignedApplications()
    {
        return $this->hasMany(Application::class, 'assigned_to');
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'citizen_id');
    }

    public function applications()
    {
        return $this->hasMany(Application::class, 'user_id');
    }

    public function vaultDocuments()
    {
        return $this->hasMany(VaultDocument::class);
    }

    public function ministry()
    {
        return $this->belongsTo(Ministry::class);
    }

    public function isMinistryScoped(): bool
    {
        return $this->role === 'staff' && $this->ministry_id !== null;
    }
}
