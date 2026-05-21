<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Ministry;
use App\Models\OffDay;
use App\Models\Service;
use App\Models\TaskType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            'total'        => Application::count(),
            'submitted'    => Application::where('current_status', 'submitted')->count(),
            'received'     => Application::where('current_status', 'received')->count(),
            'under_review' => Application::where('current_status', 'under_review')->count(),
            'approved'     => Application::where('current_status', 'approved')->count(),
            'rejected'     => Application::where('current_status', 'rejected')->count(),
            'citizens'     => User::where('role', 'citizen')->count(),
            'today'        => Application::whereDate('created_at', today())->count(),
        ];

        $recent = Application::with(['appointment', 'user'])
            ->latest()
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recent'));
    }

    public function offDays(Request $request)
    {
        $year = (int) $request->get('year', now()->year);

        $offDays = OffDay::whereYear('date', $year)
            ->orderBy('date')
            ->get();

        return view('admin.off-days.index', compact('offDays', 'year'));
    }

    public function users()
    {
        $users      = User::with(['taskTypes', 'subRoles', 'ministry'])->latest()->paginate(15);
        $taskTypes  = TaskType::orderBy('name')->get();
        $subRoles   = \App\Models\SubRole::orderBy('name')->get();
        $staffUsers = User::where('role', 'staff')->with(['taskTypes', 'subRoles', 'ministry'])->get();
        $ministries = Ministry::orderBy('order')->get();

        return view('admin.users', compact('users', 'taskTypes', 'subRoles', 'staffUsers', 'ministries'));
    }

    public function updateUserRole(Request $request, User $user)
    {
        if ($user->is(Auth::user())) {
            return redirect()->route('admin.users')
                ->with('error', 'You cannot change your own role.');
        }

        $request->validate([
            'role' => 'required|in:citizen,staff,admin',
        ]);

        $user->update(['role' => $request->role]);

        return redirect()->route('admin.users')
            ->with('success', 'User role updated successfully.');
    }

    public function updateUserMinistry(Request $request, User $user)
    {
        $request->validate([
            'ministry_id' => 'nullable|exists:ministries,id',
        ]);

        $user->update(['ministry_id' => $request->ministry_id ?: null]);

        return redirect()->route('admin.users')
            ->with('success', 'Ministry assignment updated.');
    }

    public function addOffDay(Request $request)
    {
        $request->validate([
            // SECURITY: max:2000 allows ~100 comma-separated dates while blocking oversized payloads
            'dates'  => 'required|string|max:2000',
            'reason' => 'nullable|string|max:255',
        ]);

        $dates = array_filter(array_map('trim', explode(',', $request->dates)));
        $added = 0;

        foreach ($dates as $date) {
            if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
                continue;
            }

            OffDay::firstOrCreate(
                ['date' => $date],
                ['reason' => $request->reason, 'created_by' => Auth::id()]
            );
            $added++;
        }

        return redirect()->route('admin.offdays')
            ->with('success', "$added off day(s) added successfully.");
    }

    public function removeOffDay(OffDay $offDay)
    {
        $offDay->delete();

        return redirect()->route('admin.offdays')
            ->with('success', 'Off day removed.');
    }

    public function taskTypes()
    {
        $taskTypes = TaskType::withCount('staff')->latest()->get();
        $staffUsers = User::where('role', 'staff')->with('taskTypes')->get();
        $allApplications = Application::with(['user', 'assignedStaff'])->latest()->get();

        return view('admin.task-types.index', compact('taskTypes', 'staffUsers', 'allApplications'));
    }

    public function storeTaskType(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:100|unique:task_types,name',
            'color' => 'required|in:indigo,green,blue,amber,rose,purple',
        ]);

        TaskType::create([
            'name'       => $request->name,
            'color'      => $request->color,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('admin.task-types')
            ->with('success', "Task type \"{$request->name}\" created.");
    }

    public function destroyTaskType(TaskType $taskType)
    {
        $taskType->delete();

        return redirect()->route('admin.task-types')
            ->with('success', 'Task type deleted.');
    }

    public function updateStaffTaskTypes(Request $request, User $user)
    {
        abort_if($user->role !== 'staff', 403, 'User is not a staff member.');

        $request->validate([
            'task_type_ids'   => 'nullable|array',
            'task_type_ids.*' => 'exists:task_types,id',
        ]);

        $user->taskTypes()->sync($request->task_type_ids ?? []);

        return redirect()->back()->with('success', "Task types updated for {$user->name}.");
    }

    public function assignApplication(Request $request, Application $application)
    {
        $request->validate([
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        if ($request->assigned_to) {
            $staff = User::findOrFail($request->assigned_to);
            abort_if($staff->role !== 'staff', 422, 'Target user is not a staff member.');
        }

        $application->update(['assigned_to' => $request->assigned_to]);

        $msg = $request->assigned_to
            ? "Application assigned to " . User::find($request->assigned_to)->name . "."
            : "Application unassigned.";

        return redirect()->back()->with('success', $msg);
    }

    public function services()
    {
        $ministries = Ministry::with(['services' => fn ($q) => $q->orderBy('name')])
            ->orderBy('order')
            ->get();

        $stats = [
            'total'    => Service::count(),
            'active'   => Service::where('is_active', true)->count(),
            'inactive' => Service::where('is_active', false)->count(),
        ];

        return view('admin.services.index', compact('ministries', 'stats'));
    }

    public function toggleService(Service $service)
    {
        $service->update(['is_active' => !$service->is_active]);

        $state = $service->is_active ? 'activated' : 'deactivated';

        return redirect()->route('admin.services')
            ->with('success', "\"{$service->name}\" has been {$state}.");
    }
}
