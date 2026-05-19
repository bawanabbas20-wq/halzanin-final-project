<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubRole extends Model
{
    protected $fillable = ['name', 'description', 'created_by'];

    const PERMISSIONS = [
        'view_queue'                => ['label' => 'View Queue',                'desc' => 'View the application queue and applicant list'],
        'confirm_appointments'      => ['label' => 'Confirm Appointments',      'desc' => 'Confirm, complete, or cancel appointments'],
        'scan_qr_checkin'           => ['label' => 'QR Check-in',               'desc' => 'Scan citizen QR codes to register arrivals'],
        'update_application_status' => ['label' => 'Update Application Status', 'desc' => 'Move applications through review stages'],
        'view_documents'            => ['label' => 'View Documents',            'desc' => 'Open uploaded files and vault documents'],
        'verify_documents'          => ['label' => 'Verify Documents',          'desc' => 'Mark submitted documents as verified'],
        'view_analytics'            => ['label' => 'View Analytics',            'desc' => 'Access dashboard statistics and charts'],
        'manage_off_days'           => ['label' => 'Manage Off Days',           'desc' => 'Add and remove off days from the booking calendar'],
    ];

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
