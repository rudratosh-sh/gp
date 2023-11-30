<?php

use Illuminate\Support\Facades\Auth;
use \App\Models\Message;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

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

if (!function_exists('showMessagesWithUsers')) {
    function showMessagesWithUsers()
    {
        $user = Auth::user();

        if (!$user) {
            return new Collection(); // No user logged in, return an empty collection
        }
        $userId = Auth::user()->id;

        $threads = DB::table('users')
            ->select(
                'users.name',
                'users.id',
                'users.avatar',
                DB::raw('COALESCE(latest_message.message_content, "") AS latest_message_content'),
                DB::raw('SUM(CASE WHEN m.receiver_id = ' . $userId . ' AND m.is_read = 0 THEN 1 ELSE 0 END) AS unread')
            )
            ->leftJoin(DB::raw('(SELECT
                CASE
                    WHEN sender_id = ' . $userId . ' THEN receiver_id
                    ELSE sender_id
                END AS user_id,
                MAX(message_content) AS message_content
            FROM messages
            WHERE sender_id = ' . $userId . ' OR receiver_id = ' . $userId . '
            GROUP BY
                CASE
                    WHEN sender_id = ' . $userId . ' THEN receiver_id
                    ELSE sender_id
                END) AS latest_message'), 'users.id', '=', 'latest_message.user_id')
            ->leftJoin('messages as m', function ($join) {
                $join->on('users.id', '=', 'm.sender_id')
                    ->orWhere('users.id', '=', 'm.receiver_id');
            })
            ->where(function ($query) use ($userId) {
                $query->where('m.sender_id', $userId)
                    ->orWhere('m.receiver_id', $userId);
            })
            ->where('users.id', '!=', $userId)
            ->groupBy('users.id')
            ->orderByDesc('id')
            ->get();

        return $threads;
    }
}
