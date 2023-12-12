<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Staff;
use Orchid\Platform\Models\User;

class StaffUpdated
{
    use Dispatchable, SerializesModels;

    public $staff;
    public $user;

    public function __construct(Staff $staff, User $user)
    {
        $this->staff = $staff;
        $this->user = $user;
    }
}
