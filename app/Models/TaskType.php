<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskType extends Model
{
    protected $fillable = ['name', 'color', 'created_by'];

    public function staff()
    {
        return $this->belongsToMany(User::class, 'staff_task_type');
    }

    public function colorClasses(): string
    {
        return match ($this->color) {
            'green'  => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
            'blue'   => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
            'amber'  => 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400',
            'rose'   => 'bg-rose-100 text-rose-700 dark:bg-rose-900/30 dark:text-rose-400',
            'purple' => 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400',
            default  => 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-400',
        };
    }
}
