<?php

namespace App\Http\Controllers;

use App\Models\SubRole;
use App\Models\SubRolePermission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubRoleController extends Controller
{
    private const ALL_PERMISSIONS = [
        'view_queue', 'confirm_appointments', 'scan_qr_checkin',
        'update_application_status', 'view_documents', 'verify_documents',
        'view_analytics', 'manage_off_days',
    ];

    public function index()
    {
        $subRoles = SubRole::with('permissions')->withCount('users')->get();

        $permissionCounts = [];
        foreach (self::ALL_PERMISSIONS as $perm) {
            $permissionCounts[$perm] = User::where('role', 'staff')
                ->whereHas('subRoles.permissions', fn($q) => $q->where('permission', $perm))
                ->count();
        }

        return view('admin.sub-roles.index', [
            'subRoles'         => $subRoles,
            'allPermissions'   => self::ALL_PERMISSIONS,
            'permissionCounts' => $permissionCounts,
        ]);
    }

    public function create()
    {
        return view('admin.sub-roles.create', [
            'allPermissions' => self::ALL_PERMISSIONS,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:100|unique:sub_roles,name',
            'description'   => 'nullable|string|max:500',
            'permissions'   => 'nullable|array',
            'permissions.*' => 'in:' . implode(',', self::ALL_PERMISSIONS),
        ]);

        $subRole = SubRole::create([
            'name'        => $request->name,
            'description' => $request->description,
            'created_by'  => Auth::id(),
        ]);

        foreach ($request->permissions ?? [] as $permission) {
            SubRolePermission::create([
                'sub_role_id' => $subRole->id,
                'permission'  => $permission,
            ]);
        }

        return redirect()->route('admin.sub-roles.index')
            ->with('success', "Sub-role \"{$subRole->name}\" created successfully.");
    }

    public function edit($id)
    {
        $subRole = SubRole::with('permissions')->findOrFail($id);

        return view('admin.sub-roles.edit', [
            'subRole'        => $subRole,
            'allPermissions' => self::ALL_PERMISSIONS,
        ]);
    }

    public function update(Request $request, $id)
    {
        $subRole = SubRole::findOrFail($id);

        $request->validate([
            'name'          => 'required|string|max:100|unique:sub_roles,name,' . $id,
            'description'   => 'nullable|string|max:500',
            'permissions'   => 'nullable|array',
            'permissions.*' => 'in:' . implode(',', self::ALL_PERMISSIONS),
        ]);

        $subRole->update([
            'name'        => $request->name,
            'description' => $request->description,
        ]);

        // Sync permissions
        $subRole->permissions()->delete();
        foreach ($request->permissions ?? [] as $permission) {
            SubRolePermission::create([
                'sub_role_id' => $subRole->id,
                'permission'  => $permission,
            ]);
        }

        return redirect()->route('admin.sub-roles.index')
            ->with('success', "Sub-role \"{$subRole->name}\" updated.");
    }

    public function destroy($id)
    {
        $subRole = SubRole::findOrFail($id);
        $name = $subRole->name;

        // Detach all users first (pivot cascade handles DB, but explicit for safety)
        $subRole->users()->detach();
        $subRole->delete();

        return redirect()->route('admin.sub-roles.index')
            ->with('success', "Sub-role \"{$name}\" deleted.");
    }

    public function assign(Request $request, $userId)
    {
        $request->validate(['sub_role_id' => 'required|exists:sub_roles,id']);

        $user = User::where('role', 'staff')->findOrFail($userId);

        if ($user->subRoles()->where('sub_role_id', $request->sub_role_id)->exists()) {
            return back()->with('error', 'This sub-role is already assigned to the user.');
        }

        $user->subRoles()->attach($request->sub_role_id, ['assigned_by' => Auth::id()]);

        $subRole = SubRole::find($request->sub_role_id);
        return back()->with('success', "Sub-role \"{$subRole->name}\" assigned to {$user->name}.");
    }

    public function unassign($userId, $subRoleId)
    {
        $user    = User::findOrFail($userId);
        $subRole = SubRole::findOrFail($subRoleId);

        $user->subRoles()->detach($subRoleId);

        return back()->with('success', "Sub-role \"{$subRole->name}\" removed from {$user->name}.");
    }
}
