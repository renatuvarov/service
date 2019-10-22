<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TicketDeleted extends Mailable
{
    use Queueable, SerializesModels;

    private $ticket;

    public function __construct($ticket)
    {
        $this->ticket = $ticket;
    }

    public function build()
    {
        return $this->markdown('emails.ticket-deleted')->with([
            'ticket' => $this->ticket,
        ]);
    }
}
