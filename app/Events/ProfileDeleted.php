<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ProfileDeleted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $tickets;

    public function __construct($tickets)
    {
        $this->tickets = $tickets;
    }
}
