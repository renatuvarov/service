<?php

namespace App\Http\Controllers\Tickets;

use App\Entity\Ticket;
use App\Http\Controllers\Controller;
use App\Http\Requests\FindTickets;
use App\Http\Requests\OrderRequest;
use App\Http\Services\FindCitiesService;
use App\Jobs\RestoreSeatJob;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

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

    public function orderForm(Ticket $ticket)
    {
        if ($ticket->seat === 0) {
            return redirect()->route('tickets.failed');
        }

        $user = Auth::user();

        if (! Redis::exists('order.' . $user->id)) {
            Redis::set('order.' . $user->id, $ticket->id);

            $ticket->update([
                'seat' => $ticket->seat - 1,
            ]);

            $job = (new RestoreSeatJob($ticket->id, $user->id))
                ->delay(Carbon::now()->addSeconds(20));

            $this->dispatch($job);
        }

        return view('tickets.form', compact('user', 'ticket'));

    }

    public function order(OrderRequest $request)
    {
        $user = $request->user();

        if (! Redis::exists('order.' . $user->id)) {
            return redirect()->route('tickets.failed');
        }

        $ticket = Ticket::findOrFail($request->route('ticket'));

        Redis::del('order.' . $user->id);

        $user->tickets()->attach($ticket, [
            'name' => $request->input('name'),
            'surname' => $request->input('surname'),
            'patronymic' => $request->input('patronymic'),
            'phone' => $request->input('phone'),
            'status' => 'waiting',
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
