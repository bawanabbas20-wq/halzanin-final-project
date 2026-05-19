<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\OffDay;
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
            'received'     => 0,
            'under_review' => Application::where('current_status', 'under_review')->count(),
            'approved'     => Application::where('current_status', 'approved')->count(),
            'rejected'     => Application::where('current_status', 'rejected')->count(),
            'citizens'     => User::where('role', 'citizen')->count(),
            'today'        => Application::whereDate('created_at', today())->count(),
        ];

        $recent = Application::with(['user', 'appointment'])
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recent'));
    }

    public function users()
    {
        $users = User::orderByDesc('created_at')->paginate(20);
        return view('admin.users', compact('users'));
    }

    public function updateRole(Request $request, User $user)
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'You cannot change your own role.');
        }

        $request->validate(['role' => 'required|in:citizen,staff,admin']);
        $user->update(['role' => $request->role]);

        return back()->with('success', "{$user->name}'s role updated to {$request->role}.");
    }

    public function offDays(Request $request)
    {
        $year = (int) $request->get('year', now()->year);

        $offDays = OffDay::whereYear('date', $year)
            ->orderBy('date')
            ->get();

        return view('admin.off-days.index', compact('offDays', 'year'));
    }

    public function addOffDay(Request $request)
    {
        $request->validate([
            'dates'  => 'required|string',
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
}
