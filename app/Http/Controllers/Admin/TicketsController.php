<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Ticket;
use App\Events\TicketDeleted;
use App\Events\TicketUpdated;
use App\Http\Requests\AdminTicketsSearchRequest;
use App\Http\Requests\CreateTicketRequest;
use App\Http\Requests\TicketUpdatedRequest;
use App\Http\Requests\TicketUsersSearchRequest;
use App\Http\Services\AdminSearchService;
use App\Http\Services\CalendarService;
use App\Http\Controllers\Controller;
use App\Http\Services\ManageTicketsService;
use App\Jobs\RemoveOldTicket;

class TicketsController extends Controller
{
    /**
     * @var CalendarService
     */
    private $calendar;
    /**
     * @var AdminSearchService
     */
    private $adminSearchService;
    /**
     * @var ManageTicketsService
     */
    private $manageTicketsService;

    public function __construct(CalendarService $calendar, AdminSearchService $adminSearchService, ManageTicketsService $manageTicketsService)
    {
        $this->calendar = $calendar;
        $this->adminSearchService = $adminSearchService;
        $this->manageTicketsService = $manageTicketsService;
    }

    public function index(AdminTicketsSearchRequest $request)
    {
        $tickets = $this->adminSearchService
            ->ticketsWithQuery(Ticket::with('cities'), $request->all())
            ->paginate(4);
        $calendar = $this->calendar->calendar();
        return view('admin.tickets.index', compact('tickets', 'calendar'));
    }

    public function create()
    {
        $calendar = $this->calendar->calendar();
        return view('admin.tickets.create', compact('calendar'));
    }

    public function store(CreateTicketRequest $request)
    {
        $ticket = $this->manageTicketsService->create($request->all());

        $delay = strtotime($request->input('date') . ' ' . $request->input('time')) - time();
        dispatch((new RemoveOldTicket($ticket->id))->delay($delay));

        return redirect()->route('admin.tickets.index');
    }

    public function show(TicketUsersSearchRequest $request, Ticket $ticket)
    {
        $users = $this->adminSearchService->usersWithQuery($ticket->users(), $request->all())
            ->withPivot('name', 'surname', 'patronymic', 'phone', 'status')
            ->paginate(1);
        return view('admin.tickets.show', compact('users', 'ticket'));
    }

    public function edit(Ticket $ticket)
    {
        return view('admin.tickets.edit', compact('ticket'));
    }

    public function update(TicketUpdatedRequest $request)
    {
        $ticket = Ticket::with('cities')
            ->where('id', $request->route('ticket'))
            ->first();
        $oldTime = $ticket->time;
        $users = $ticket->users()->pluck('id')->toArray();
        $ticket->update(['time' => $request->input('time')]);
        $this->manageTicketsService->update($ticket);

        event(new TicketUpdated($users, $ticket, $oldTime));

        return redirect()->route('admin.tickets.show', ['ticket' => $ticket->id]);
    }

    public function destroy($ticket)
    {
        $ticket = Ticket::with('cities')->where('id', $ticket)->first();
        $users = $ticket->users()->pluck('id')->toArray();

        event(new TicketDeleted($this->manageTicketsService->delete($ticket), $users));

        return redirect()->route('admin.tickets.index');
    }
}
