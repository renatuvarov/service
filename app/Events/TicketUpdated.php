<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class TicketUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $users;
    public $ticket;
    public $oldTime;

    public function __construct($users, $ticket, $oldTime)
    {
        $this->users = $users;
        $this->ticket = $ticket;
        $this->oldTime = $oldTime;
    }
}
