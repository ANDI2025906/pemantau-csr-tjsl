<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        
        return back()->with('success', 'All notifications marked as read');
    }

    public function markAsRead($id)
    {
        auth()->user()->notifications->where('id', $id)->first()?->markAsRead();
        
        return back()->with('success', 'Notification marked as read');
    }
}
