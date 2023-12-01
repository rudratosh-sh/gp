<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Message;
use App\Models\User; // Import the User model
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PusherBroadcast implements ShouldBroadcast
{
    public Message $message;
    public User $user; // Add the user object
    private int $recipientUserId;

    public function __construct(Message $message, int $recipientUserId, User $user)
    {
        $this->message = $message;
        $this->recipientUserId = $recipientUserId;
        $this->user = $user;
    }

    public function broadcastOn(): Channel
    {
        return new Channel('private-user.' . $this->recipientUserId);
    }

    public function broadcastWith(): array
    {
        return [
            'message' => $this->message,
            'user' => $this->user, // Include the user details
        ];
    }

    public function broadcastAs(): string
    {
        return 'chat';
    }
}
