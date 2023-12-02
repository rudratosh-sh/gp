<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Events\PusherBroadcast;
use App\Models\User;

class NotificationController extends Controller
{
    // Get notifications for the authenticated user
    public function getNotifications()
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'User not authenticated'], 401);
        }

        $notifications = $user->notifications()->get();

        return response()->json($notifications);
    }

    // Mark a notification as read for the authenticated user
    public function markAsRead(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'User not authenticated'], 401);
        }

        $notificationId = $request->input('notification_id');

        $notification = $user->notifications()->where('id', $notificationId)->first();

        if ($notification) {
            $notification->markAsRead();
            return response()->json(['message' => 'Notification marked as read']);
        } else {
            return response()->json(['message' => 'Notification not found'], 404);
        }
    }

    // Send a notification to a specific user
    public function sendNotification(Request $request)
    {
        // Validate the request data (you might need additional validation)
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'title' => 'required',
            'message' => 'required'
        ]);

        $notification = new Notification([
            'title' => $request->title,
            'message' => $request->message,
            'receiver_id' => $request->receiver_id,
            // Add other fields as needed
        ]);

        $notification->save();

        // Broadcast the event with the notification data
        $receiverDetails = User::find($request->receiver_id);
        broadcast(new PusherBroadcast($notification, $request->receiver_id, $receiverDetails));

        return response()->json(['message' => 'Notification sent successfully']);
    }

    // Other methods for managing notifications can be added here
}
