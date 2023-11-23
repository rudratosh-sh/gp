<?php

use Illuminate\Support\Facades\Auth;

if (!function_exists('showNotifications')) {
    function showNotifications()
    {
        $user = Auth::user();
        if (!$user) {
            return collect(); // No user logged in, return an empty collection
        }
        $notifications = $user->notifications; // Assuming you have a notifications relationship on the User model
        return $notifications;
    }
}

if (!function_exists('storeNotification')) {
    function storeNotification($data)
    {
        \App\Models\Notification::create($data);
    }
}
