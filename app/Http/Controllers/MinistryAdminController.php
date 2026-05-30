<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\OffDay;
use App\Models\SubRole;
use App\Models\User;
use Illuminate\Http\Request;

class MinistryAdminController extends Controller
{
    // Resolves the ministry_admin's ministry or aborts if none assigned.
    private function ministry()
    {
        return auth()->user()->ministry ?? abort(403, 'No ministry assigned to your account.');
    }

    // Guard: ensure the target user belongs to this ministry_admin's ministry.
    private function assertSameMinistry(User $user): void
    {
        if ($user->ministry_id !== $this->ministry()->id) {
            abort(403, 'This user does not belong to your ministry.');
        }
    }

    public function dashboard()
    {
        $ministry = $this->ministry();

        $stats = [
            'staff'   => User::where('role', 'staff')->where('ministry_id', $ministry->id)->count(),
            'pending' => Application::whereHas('service', fn($q) => $q->where('ministry_id', $ministry->id))
                             ->whereIn('current_status', ['submitted', 'received'])->count(),
            'today'   => Application::whereHas('service', fn($q) => $q->where('ministry_id', $ministry->id))
                             ->whereDate('created_at', today())->count(),
            'total'   => Application::whereHas('service', fn($q) => $q->where('ministry_id', $ministry->id))->count(),
        ];

        $recentApplications = Application::with(['user', 'service'])
            ->whereHas('service', fn($q) => $q->where('ministry_id', $ministry->id))
            ->latest()->limit(5)->get();

        return view('ministry-admin.dashboard', compact('ministry', 'stats', 'recentApplications'));
    }

    public function users()
    {
        $ministry = $this->ministry();

        $staff = User::with('subRoles')
            ->whereIn('role', ['staff'])
            ->where('ministry_id', $ministry->id)
            ->latest()
            ->get();

        $subRoles = SubRole::orderBy('name')->get();

        return view('ministry-admin.users', compact('ministry', 'staff', 'subRoles'));
    }

    // Find a citizen by email and promote them to staff in this ministry.
    public function promoteToStaff(Request $request)
    {
        $ministry = $this->ministry();

        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->firstOrFail();

        if ($user->role !== 'citizen') {
            return back()->with('error', '"' . $user->name . '" is not a citizen — only citizens can be promoted to staff.');
        }

        $user->update([
            'role'        => 'staff',
            'ministry_id' => $ministry->id,
        ]);

        return back()->with('success', $user->name . ' is now staff at ' . $ministry->name . '.');
    }

    // Demote staff back to citizen and clear their ministry + sub-roles.
    public function removeStaff(User $user)
    {
        $this->assertSameMinistry($user);

        if ($user->role !== 'staff') {
            abort(422, 'User is not a staff member.');
        }

        $user->subRoles()->detach();
        $user->update(['role' => 'citizen', 'ministry_id' => null]);

        return back()->with('success', $user->name . ' has been removed from staff.');
    }

    // Assign a sub-role to one of this ministry's staff.
    public function assignSubRole(Request $request, User $user)
    {
        $this->assertSameMinistry($user);

        $request->validate(['sub_role_id' => 'required|exists:sub_roles,id']);

        $user->subRoles()->syncWithoutDetaching([
            $request->sub_role_id => ['assigned_by' => auth()->id()],
        ]);

        return back()->with('success', 'Sub-role assigned successfully.');
    }

    // Remove a sub-role from one of this ministry's staff.
    public function removeSubRole(User $user, int $subRoleId)
    {
        $this->assertSameMinistry($user);
        $user->subRoles()->detach($subRoleId);
        return back()->with('success', 'Sub-role removed.');
    }

    public function offDays()
    {
        $ministry = $this->ministry();

        $offDays = OffDay::where('ministry_id', $ministry->id)
            ->orderBy('date')
            ->get();

        return view('ministry-admin.off-days', compact('ministry', 'offDays'));
    }

    public function storeOffDay(Request $request)
    {
        $ministry = $this->ministry();

        $request->validate([
            'date'   => 'required|date|after_or_equal:today',
            'reason' => 'nullable|string|max:255',
        ]);

        OffDay::create([
            'date'        => $request->date,
            'reason'      => $request->reason,
            'created_by'  => auth()->id(),
            'ministry_id' => $ministry->id,
        ]);

        return back()->with('success', 'Off day added for ' . $ministry->name . '.');
    }

    public function destroyOffDay(OffDay $offDay)
    {
        if ($offDay->ministry_id !== $this->ministry()->id) {
            abort(403);
        }

        $offDay->delete();
        return back()->with('success', 'Off day removed.');
    }
}
