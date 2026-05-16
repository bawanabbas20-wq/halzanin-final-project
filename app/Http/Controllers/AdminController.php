<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\User;
use Illuminate\Http\Request;

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
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recent'));
    }

    public function users()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.users', compact('users'));
    }

    public function updateRole(Request $request, $id)
    {
        if ((int) $id === auth()->id()) {
            abort(403, 'You cannot change your own role.');
        }

        $request->validate([
            'role' => 'required|in:citizen,staff,admin',
        ]);

        $user = User::findOrFail($id);
        $user->role = $request->role;
        $user->save();

        return redirect()->route('admin.users')->with('success', "Role for {$user->name} updated to {$user->role}.");
    }
}

