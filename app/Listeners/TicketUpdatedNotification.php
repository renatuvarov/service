<?php

namespace App\Listeners;

use App\Events\TicketUpdated;
use App\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\TicketUpdated as MailMessage;

class TicketUpdatedNotification implements ShouldQueue
{
    public function handle(TicketUpdated $event)
    {
        $users = User::find($event->users);

        if ($users->count() > 0) {
            Mail::to($users)->send(new MailMessage($event->ticket, $event->oldTime));
        }
    }
}
