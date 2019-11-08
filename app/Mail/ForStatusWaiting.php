<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ForStatusWaiting extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var array
     */
    private $ticket;

    public function __construct(array $ticket)
    {
        $this->ticket = $ticket;
    }

    public function build()
    {
        return $this->markdown('emails.for-status-waiting')
            ->with(['ticket' => $this->ticket]);
    }
}
