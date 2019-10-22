<?php

namespace App\Listeners;

use App\Events\TicketDeleted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\TicketDeleted as MailMessage;

class TicketDeletedNotification implements ShouldQueue
{
    public function handle(TicketDeleted $event)
    {
        if ($event->users->count() > 0) {
            Mail::to($event->users)->send(new MailMessage($event->ticket));
        }
    }
}
