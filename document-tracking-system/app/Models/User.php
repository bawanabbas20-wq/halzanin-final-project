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

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone_number',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'citizen_id');
    }

    public function vaultDocuments()
    {
        return $this->hasMany(VaultDocument::class);
    }

    public function subRoles()
    {
        return $this->belongsToMany(SubRole::class, 'user_sub_roles')
            ->withPivot('assigned_by')
            ->withTimestamps();
    }

    public function hasPermission(string $permission): bool
    {
        // Admins always have full access
        if ($this->role === 'admin') {
            return true;
        }

        // Non-staff never pass permission gates
        if ($this->role !== 'staff') {
            return false;
        }

        // Staff with no sub-roles assigned: backward-compatible full access
        if (!$this->subRoles()->exists()) {
            return true;
        }

        // Staff with sub-roles: check if any assigned sub-role grants this permission
        return $this->subRoles()
            ->whereHas('permissions', fn($q) => $q->where('permission', $permission))
            ->exists();
    }
}
