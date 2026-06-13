<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountDeletion extends Model
{
    protected $fillable = [
        'deleted_user_id',
        'name',
        'email',
        'role',
        'gov_id',
        'reason',
        'deleted_by',
        'deleted_by_name',
    ];

    /**
     * The admin who performed the deletion (nullable if they were later removed).
     */
    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
}
