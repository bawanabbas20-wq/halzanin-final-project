<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ministry extends Model
{
    protected $fillable = ['name', 'name_ku', 'slug', 'color', 'order'];

    public function services()
    {
        return $this->hasMany(Service::class)->orderBy('id');
    }

    public function activeServices()
    {
        return $this->hasMany(Service::class)->where('is_active', true)->orderBy('id');
    }

    public function staff()
    {
        return $this->hasMany(User::class);
    }
}
