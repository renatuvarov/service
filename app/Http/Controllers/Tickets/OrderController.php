<?php

namespace App\Http\Controllers\Tickets;

use App\Entity\Ticket;
use App\Http\Controllers\Controller;
use App\Http\Requests\FindTickets;
use App\Http\Services\FindCitiesService;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * @var FindCitiesService
     */
    private $service;

    public function __construct(FindCitiesService $service)
    {
        $this->service = $service;
    }

    public function index(FindTickets $request)
    {
        $user = Auth::user();

        $cities = $this->service->findCity(
            $request->input('departure_point'),
            $request->input('arrival_point')
        );

        $tickets = Ticket::where('departure_point', $cities['departure_point']->id)
            ->where('arrival_point', $cities['arrival_point']->id)
            ->whereDate('date', $request->input('date'))
            ->where('seat', '>', 0)
            ->whereNotIn('id', $user->tickets()->pluck('id')->toArray())
            ->orderBy('date')
            ->orderBy('time')
            ->paginate(2);

        return view('tickets.index', compact('user', 'tickets'));
    }

    public function order(Ticket $ticket)
    {
        if ($ticket->seat === 0) {
            return redirect()->route('tickets.failed');
        }

        $ticket->update([
            'seat' => $ticket->seat - 1,
        ]);

        $user = Auth::user();
        $user->tickets()->attach($ticket, [
            'name' => $user->name,
            'surname' => $user->surname,
            'patronymic' => $user->patronymic,
            'phone' => $user->phone,
        ]);

        return redirect()->route('user.home');
    }

    public function failed()
    {
        return view('tickets.order-failed');
    }

    public function remove(Ticket $ticket)
    {
        $user = Auth::user();

        $user->tickets()->detach($ticket);

        $ticket->update([
            'seat' => $ticket->seat + 1,
        ]);

        return redirect()->route('user.home');
    }
}
