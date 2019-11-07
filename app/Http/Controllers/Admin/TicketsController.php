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
use App\Http\Services\FindCitiesService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TicketsController extends Controller
{
    /**
     * @var CalendarService
     */
    private $calendar;

    private $search;
    /**
     * @var AdminSearchService
     */
    private $adminSearchService;

    public function __construct(CalendarService $calendar, FindCitiesService $search, AdminSearchService $adminSearchService)
    {
        $this->calendar = $calendar;
        $this->search = $search;
        $this->adminSearchService = $adminSearchService;
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
        $cities = $this->search->findCity(
            $request->input('departure_point'),
            $request->input('arrival_point')
        );

        $ticket = Ticket::create([
            'departure_point' => $cities['departure_point']->id,
            'arrival_point' => $cities['arrival_point']->id,
            'date' => $request->input('date'),
            'time' => $request->input('time'),
            'seat' => $request->input('seats'),
        ]);

        $ticket->cities()->attach($cities['departure_point']);
        $ticket->cities()->attach($cities['arrival_point']);

        $this->adminSearchService->index($ticket);

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

        $ticket->update([
            'time' => $request->input('time')
        ]);

        $this->adminSearchService->update($ticket);

        event(new TicketUpdated($users, $ticket, $oldTime));

        return redirect()->route('admin.tickets.show', ['ticket' => $ticket->id]);
    }

    public function destroy($ticket)
    {
        $ticket = Ticket::with('cities')->where('id', $ticket)->first();
        $users = $ticket->users()->pluck('id')->toArray();

        $ticket->delete();
        $this->adminSearchService->delete($ticket);

        $ticketArray = $ticket->toArray();
        $ticketArray['departure_point'] = $ticket->departurePoint();
        $ticketArray['arrival_point'] = $ticket->arrivalPoint();

        event(new TicketDeleted($ticketArray, $users));

        return redirect()->route('admin.main');
    }
}
