<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TicketInfo extends Mailable
{
    use Queueable, SerializesModels;

    private $message;
    private $ticket;

    public function __construct($message, $ticket)
    {
        $this->message = $message;
        $this->ticket = $ticket;
    }

    public function build()
    {
        return $this->markdown('emails.ticket-info')->with([
            'message' => $this->message,
            'ticket' => $this->ticket,
        ]);
    }
}
