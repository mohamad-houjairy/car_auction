<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
class NotificationController extends Controller
{
   
    /**
     * Show the notifications for the authenticated user.
     *
     * @return \Illuminate\View\View
     */
    
    public function index()
    {
        // Get the authenticated user
        $user = auth()->user();

        // Fetch all notifications for the user using the query builder explicitly
        $notifications = $user->notifications;

        // Return the view with the notifications
        return view('notifications.index', compact('notifications'));
    }

    /**
     * Mark a specific notification as read.
     *
     * @param  int  $notificationId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function markAsRead($notificationId)
    {
        // Get the authenticated user
        $user = auth()->user();

        // Fetch the notification by its ID
        $notification = $user->notifications->firstWhere('id', $notificationId);

     
        // Mark the notification as read
        $notification->markAsRead();
        // Redirect back to notifications page
        return redirect()->route('notifications.index');
    }
 


}

