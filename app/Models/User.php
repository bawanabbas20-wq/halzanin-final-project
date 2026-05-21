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
    ];

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
        if ($this->role === 'admin') {
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
