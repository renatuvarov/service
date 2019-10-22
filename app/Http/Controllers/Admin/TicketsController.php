<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Ticket;
use App\Events\TicketDeleted;
use App\Events\TicketUpdated;
use App\Http\Requests\CreateTicketRequest;
use App\Http\Requests\TicketUpdatedRequest;
use App\Http\Services\DateTimeService;
use App\Http\Services\FindCitiesService;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TicketsController extends Controller
{
    /**
     * @var DateTimeService
     */
    private $dateTimeService;

    private $search;

    public function __construct(DateTimeService $dateTimeService, FindCitiesService $search)
    {
        $this->dateTimeService = $dateTimeService;
        $this->search = $search;
    }

    public function index()
    {
        $tickets = Ticket::with('cities')->paginate(4);
        return view('admin.tickets.index', compact('tickets'));
    }

    public function create()
    {
        $months = $this->dateTimeService->allMonth();
        $monthNames = $this->dateTimeService->monthsFromCurrent();
        $currentDay = Carbon::now();
        return view('admin.tickets.create', compact('months', 'monthNames', 'currentDay'));
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

        return redirect()->route('admin.tickets.index');
    }

    public function show(Ticket $ticket)
    {
        $users = $ticket->users()->withPivot('name', 'surname', 'patronymic', 'phone')->paginate(1);
        $user = Auth::user();
        return view('admin.tickets.show', compact('user', 'users', 'ticket'));
    }

    public function edit(Ticket $ticket)
    {
        $user = Auth::user();
        return view('admin.tickets.edit', compact('ticket', 'user'));
    }

    public function update(TicketUpdatedRequest $request)
    {
        $ticket = Ticket::with('cities')->where('id', $request->route('ticket'))->first();
        $oldTime = $ticket->time;
        $users = $ticket->users()->get();

        $ticket->update([
            'time' => $request->input('time')
        ]);

        event(new TicketUpdated($users, $ticket, $oldTime));

        return redirect()->route('admin.tickets.show', ['ticket' => $ticket->id]);
    }

    public function destroy($ticket)
    {
        $ticket = Ticket::with('cities')->where('id', $ticket)->first();
        $users = $ticket->users()->get();

        $ticket->delete();

        $ticketArray = $ticket->toArray();
        $ticketArray['departure_point'] = $ticket->departurePoint();
        $ticketArray['arrival_point'] = $ticket->arrivalPoint();

        event(new TicketDeleted($ticketArray, $users));

        return redirect()->route('admin.main');
    }
}
