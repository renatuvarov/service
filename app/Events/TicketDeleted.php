<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class TicketDeleted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $ticket;
    public $users;

    public function __construct($ticket, $users)
    {
        $this->ticket = $ticket;
        $this->users = $users;
    }
}
