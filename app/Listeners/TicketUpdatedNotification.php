<?php

namespace App\Listeners;

use App\Events\TicketUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\TicketUpdated as MailMessage;

class TicketUpdatedNotification implements ShouldQueue
{
    public function handle(TicketUpdated $event)
    {
        if ($event->users->count() > 0) {
            Mail::to($event->users)->send(new MailMessage($event->ticket, $event->oldTime));
        }
    }
}
