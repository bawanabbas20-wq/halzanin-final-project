<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubRole extends Model
{
    protected $fillable = ['name', 'description', 'created_by'];

    public function permissions()
    {
        return $this->hasMany(SubRolePermission::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_sub_roles')
            ->withPivot('assigned_by')
            ->withTimestamps();
    }

    public function hasPermission(string $permission): bool
    {
        return $this->permissions->contains('permission', $permission);
    }
}
