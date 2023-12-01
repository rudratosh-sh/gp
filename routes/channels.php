<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Auth;
use Pusher\Pusher;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

// Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
//     return (int) $user->id === (int) $id;
// });

// Broadcast::channel('notifications.{receiverId}', function ($user, $receiverId) {
//     return $user->id === (int) $receiverId;
// });


// Broadcast::channel('private-user.{id}', function ($user, $id) {
//     Auth::check();
//     return (int) $user->id === (int) $id;
// });

Broadcast::channel('private-user.{id}', function ($user, $id) {
    if ((int) $user->id === (int) $id) {
        $pusher = new Pusher(
            config('broadcasting.connections.pusher.key'),
            config('broadcasting.connections.pusher.secret'),
            config('broadcasting.connections.pusher.app_id'),
            [
                'cluster' => config('broadcasting.connections.pusher.options.cluster'),
                'useTLS' => true,
            ]
        );

        return $pusher->socket_auth(request()->channel_name, request()->socket_id);
    }
});
