<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TicketUpdated extends Mailable
{
    use Queueable, SerializesModels;

    private $ticket;
    private $oldTime;

    public function __construct($ticket, $oldTime)
    {
        $this->ticket = $ticket;
        $this->oldTime = $oldTime;
    }

    public function build()
    {
        return $this->markdown('emails.ticket-updated')->with([
            'ticket' => $this->ticket,
            'oldTime' => $this->oldTime,
        ]);
    }
}
