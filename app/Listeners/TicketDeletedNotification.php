<?php

namespace App\Listeners;

use App\Events\TicketDeleted;
use App\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\TicketDeleted as MailMessage;

class TicketDeletedNotification implements ShouldQueue
{
    public function handle(TicketDeleted $event)
    {
        $users = User::find($event->users);

        if ($users->count() > 0) {
            Mail::to($users)->send(new MailMessage($event->ticket));
        }
    }
}
