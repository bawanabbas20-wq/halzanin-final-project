<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $user          = auth()->user();
        $notifications = $user->notifications()->latest()->take(15)->get();

        return response()->json([
            'count'         => $user->unreadNotifications()->count(),
            'notifications' => $notifications->map(fn($n) => [
                'id'         => $n->id,
                'status'     => $n->data['new_status']     ?? '',
                'tracking'   => $n->data['tracking_code']  ?? '',
                'name'       => $n->data['applicant_name'] ?? '',
                'read'       => !is_null($n->read_at),
                'time'       => $n->created_at->diffForHumans(),
            ]),
        ]);
    }

    public function markRead(string $id)
    {
        auth()->user()->notifications()->where('id', $id)->first()?->markAsRead();
        return response()->json(['ok' => true]);
    }

    public function markAllRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return response()->json(['ok' => true]);
    }
}
