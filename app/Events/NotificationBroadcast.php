<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NotificationBroadcast implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Notification $notification;
    public User $user; // Add the user object
    private int $recipientUserId;

    public function __construct(Notification $notification, int $recipientUserId, User $user)
    {
        $this->notification = $notification;
        $this->recipientUserId = $recipientUserId;
        $this->user = $user;
    }

    public function broadcastOn(): Channel
    {
        return new Channel('notification-user.' . $this->recipientUserId);
    }

    public function broadcastWith(): array
    {
        return [
            'notification' => $this->notification,
            'user' => $this->user, // Include the user details
        ];
    }

    public function broadcastAs(): string
    {
        return 'notification';
    }
}
