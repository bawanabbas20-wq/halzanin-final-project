<?php

namespace App\Http\Controllers;

use App\Models\OffDay;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
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
        $users = User::latest()->paginate(15);

        return view('admin.users', compact('users'));
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
