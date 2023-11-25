<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class NotificationEvent implements ShouldBroadcast
{
    use SerializesModels;

    public $title;
    public $message;

    /**
     * Create a new event instance.
     */
    public function __construct($title, $message)
    {
        $this->title = $title;
        $this->message = $message;

        Log::info('NotificationEvent fired:', ['title' => $title, 'message' => $message]);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('app-test');
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith()
    {
        return [
            'title' => $this->title,
            'message' => $this->message,
        ];
    }
}
