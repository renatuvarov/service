<?php

namespace App\Jobs;

use App\Entity\Ticket;
use App\Http\Services\ManageTicketsService;
use App\Mail\ForStatusWaiting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class RemoveOldTicket implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $ticketId;

    public function __construct($ticketId)
    {
        $this->ticketId = $ticketId;
    }

    public function handle(ManageTicketsService $manageTickets, Mailer $mailer)
    {
        $ticket = Ticket::find($this->ticketId);
        
        if ($ticket) {
            $users = $ticket->users()->wherePivot('status', 'waiting')->get();
            $ticketArray = $manageTickets->delete($ticket);
            
            if ($users->count() > 0) {
                $mailer->to($users)->send(new ForStatusWaiting($ticketArray));
            }
        }
    }
}
