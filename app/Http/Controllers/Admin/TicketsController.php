<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Ticket;
use App\Http\Requests\CreateTicketRequest;
use App\Http\Services\DateTimeService;
use App\Http\Services\FindCitiesService;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
        //
    }

    public function update(Request $request, Ticket $ticket)
    {
        //
    }

    public function remove(Ticket $ticket)
    {

    }

    public function destroy(Ticket $ticket)
    {
        //
    }
}
