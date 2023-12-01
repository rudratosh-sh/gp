<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Pusher\Pusher;
use App\Events\PusherBroadcast;
use App\Models\User;

class MessageController extends Controller
{
    public function authenticatePusherChannel(Request $request)
    {
        $app_key = '1a96c62d17b6395fe814';
        $app_secret = 'ed37a3cb09cf70821d68';
        $app_id = '1712697';
        $app_cluster = 'ap4';

        $pusher = new Pusher($app_key, $app_secret, $app_id, [
            'cluster' => $app_cluster,
        ]);

        $socket_id = $request->input('socket_id');
        $channel_name = $request->input('channel_name');

        // Authenticate private channel
        $auth = $pusher->authorizeChannel($channel_name, $socket_id);
        // OR authenticate presence channel
        // $user_id = 'USER_ID';
        // $user_info = ['name' => 'User Name']; // Replace with actual user info
        // $auth = $pusher->authorizePresenceChannel($channel_name, $socket_id, $user_id, $user_info);

        return $auth;
    }

    public function getMessages($otherUserId)
    {
        $currentUserId = Auth::id();

        // Fetch messages between the current user and the other user along with the other user's details
        $messages = Message::with(['sender', 'receiver'])
            ->where(function ($query) use ($currentUserId, $otherUserId) {
                $query->where('sender_id', $currentUserId)
                    ->where('receiver_id', $otherUserId);
            })->orWhere(function ($query) use ($currentUserId, $otherUserId) {
                $query->where('sender_id', $otherUserId)
                    ->where('receiver_id', $currentUserId);
            })->orderBy('id', 'asc')->get();

        return response()->json($messages);
    }

    public function getThreads()
    {
        $userId = Auth::id();

        $threads = DB::table('users')
            ->select(
                'users.name',
                'users.id',
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
            ->orderByDesc('latest_message_content')
            ->get();

        return response()->json($threads);
    }


    public function getConversation($userId)
    {
        $user = Auth::user();

        if (!$user) {
            // Handle if no user is logged in, maybe redirect or return an empty response
            return response()->json(['message' => 'User not authenticated'], 401);
        }

        // Fetch messages for the current user and the selected user
        $messages = Message::where(function ($query) use ($user, $userId) {
            $query->where('sender_id', $user->id)->where('receiver_id', $userId);
        })->orWhere(function ($query) use ($user, $userId) {
            $query->where('sender_id', $userId)->where('receiver_id', $user->id);
        })->orderBy('message.id', 'asc')
            ->get();

        return response()->json($messages);
    }

    public function sendMessage(Request $request)
    {
        // Validate the request data (you might need additional validation)
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message_content' => 'required'
        ]);

        // Create a new message
        $message = new Message();
        $message->sender_id = auth()->user()->id; // Assuming the sender is the authenticated user
        $message->receiver_id = $request->receiver_id;
        $message->message_content = $request->message_content;
        $message->save();

        $userDetails = User::find($request->receiver_id);
        // Broadcast the event with message and user details
        broadcast(new PusherBroadcast($message, $request->receiver_id, $userDetails));
        return response()->json(['message' => 'Message sent successfully']);
    }

    public function markAsRead(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            // Handle if no user is logged in, maybe redirect or return an empty response
            return response()->json(['message' => 'User not authenticated'], 401);
        }

        $receiverId = $user->id;
        $senderId = $request->input('sender_id');

        // Update messages where the receiver_id is the current user ID and sender_id matches the conversation ID
        Message::where('receiver_id', $receiverId)
            ->where('sender_id', $senderId)
            ->update(['is_read' => 1]);

        return response()->json(['success' => true]);
    }
}
