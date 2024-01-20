<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SignalEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $signalData;

    public function __construct($signalData)
    {
        $this->signalData = $signalData;
    }

    public function broadcastOn()
    {
        return new Channel('video-call-channel');
    }

    public function broadcastAs()
    {
        return 'signal-event';
    }
}
