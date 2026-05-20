<?php

namespace App\Http\Controllers;

use App\Models\SubRole;
use App\Models\SubRolePermission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SubRoleController extends Controller
{
    public const PERMISSIONS = [
        'view_queue'                => ['label' => 'View Queue',               'desc' => 'Access the application queue', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
        'confirm_appointments'      => ['label' => 'Confirm Appointments',     'desc' => 'Approve or reject appointment slots', 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
        'scan_qr_checkin'           => ['label' => 'QR Check-in Scanner',     'desc' => 'Scan citizen QR codes at the front desk', 'icon' => 'M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z M15 13a3 3 0 11-6 0 3 3 0 016 0z'],
        'update_application_status' => ['label' => 'Update App Status',        'desc' => 'Move applications through review stages', 'icon' => 'M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15'],
        'view_documents'            => ['label' => 'View Documents',           'desc' => 'Open and read submitted documents', 'icon' => 'M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z'],
        'verify_documents'          => ['label' => 'Verify Documents',         'desc' => 'Mark documents as verified or rejected', 'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'],
        'view_analytics'            => ['label' => 'View Analytics',           'desc' => 'Access dashboard stats and reports', 'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'],
        'manage_off_days'           => ['label' => 'Manage Off Days',          'desc' => 'Add or remove office off days', 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
    ];

    public function index()
    {
        $subRoles = SubRole::withCount('users')->with('permissions')->latest()->get();
        $staffUsers = User::where('role', 'staff')->with(['subRoles.permissions'])->get();
        $permissionsMap = self::PERMISSIONS;

        return view('admin.sub-roles.index', compact('subRoles', 'staffUsers', 'permissionsMap'));
    }

    public function create()
    {
        $permissionsMap = self::PERMISSIONS;
        return view('admin.sub-roles.create', compact('permissionsMap'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:100|unique:sub_roles,name',
            'description'   => 'nullable|string|max:500',
            'permissions'   => 'nullable|array',
            'permissions.*' => 'in:' . implode(',', array_keys(self::PERMISSIONS)),
        ]);

        DB::transaction(function () use ($request) {
            $subRole = SubRole::create([
                'name'        => $request->name,
                'description' => $request->description,
                'created_by'  => Auth::id(),
            ]);

            foreach ($request->permissions ?? [] as $perm) {
                SubRolePermission::create(['sub_role_id' => $subRole->id, 'permission' => $perm]);
            }
        });

        return redirect()->route('admin.sub-roles.index')
            ->with('success', "Sub-role \"{$request->name}\" created.");
    }

    public function edit(int $id)
    {
        $subRole = SubRole::with('permissions')->findOrFail($id);
        $permissionsMap = self::PERMISSIONS;
        return view('admin.sub-roles.edit', compact('subRole', 'permissionsMap'));
    }

    public function update(Request $request, int $id)
    {
        $subRole = SubRole::findOrFail($id);

        $request->validate([
            'name'          => 'required|string|max:100|unique:sub_roles,name,' . $id,
            'description'   => 'nullable|string|max:500',
            'permissions'   => 'nullable|array',
            'permissions.*' => 'in:' . implode(',', array_keys(self::PERMISSIONS)),
        ]);

        DB::transaction(function () use ($request, $subRole) {
            $subRole->update(['name' => $request->name, 'description' => $request->description]);
            $subRole->permissions()->delete();
            foreach ($request->permissions ?? [] as $perm) {
                SubRolePermission::create(['sub_role_id' => $subRole->id, 'permission' => $perm]);
            }
        });

        return redirect()->route('admin.sub-roles.index')
            ->with('success', "Sub-role \"{$subRole->name}\" updated.");
    }

    public function destroy(int $id)
    {
        $subRole = SubRole::findOrFail($id);
        $name = $subRole->name;
        $subRole->users()->detach();
        $subRole->delete();

        return redirect()->route('admin.sub-roles.index')
            ->with('success', "Sub-role \"{$name}\" deleted.");
    }

    public function assign(Request $request, int $userId)
    {
        $user = User::findOrFail($userId);
        abort_if($user->role !== 'staff', 403, 'User is not a staff member.');

        $request->validate([
            'sub_role_id' => 'required|exists:sub_roles,id',
        ]);

        $user->subRoles()->syncWithoutDetaching([
            $request->sub_role_id => ['assigned_by' => Auth::id()],
        ]);

        return redirect()->back()->with('success', "Sub-role assigned to {$user->name}.");
    }

    public function unassign(int $userId, int $subRoleId)
    {
        $user = User::findOrFail($userId);
        $user->subRoles()->detach($subRoleId);

        return redirect()->back()->with('success', 'Sub-role removed.');
    }
}
