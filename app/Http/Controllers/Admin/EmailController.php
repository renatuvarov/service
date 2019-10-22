<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Ticket;
use App\Http\Requests\TicketInfoRequest;
use App\Mail\TicketInfo;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function newEmail($ticket, $user = null)
    {
        $ticket = Ticket::find($ticket);
        $user = $user ? User::find($user) : null;
        return view('admin.emails.ticket-info', compact('user', 'ticket'));
    }

    public function sendEmail(TicketInfoRequest $request)
    {
        $ticket = Ticket::with('cities')->where('id', $request->route('ticket'))->first();
        $users = $request->route('id') ? [$request->route('id')] : $ticket->users()->pluck('id')->toArray();
        $users = User::whereIn('id', $users)->get();
        $message = $request->input('message');

        Mail::to($users)->queue(new TicketInfo($message, $ticket));

        return redirect()->route('admin.tickets.show', ['ticket' => $ticket->id]);
    }
}
