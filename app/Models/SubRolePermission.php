<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubRolePermission extends Model
{
    protected $fillable = ['sub_role_id', 'permission'];

    public function subRole()
    {
        return $this->belongsTo(SubRole::class);
    }
}
