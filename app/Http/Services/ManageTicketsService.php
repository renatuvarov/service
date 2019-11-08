<?php

namespace App\Http\Services;

use App\Entity\Ticket;
use App\Http\Services\Elasticsearch\TicketService;

class ManageTicketsService
{
    /**
     * @var TicketService
     */
    private $service;
    /**
     * @var FindCitiesService
     */
    private $find;

    public function __construct(TicketService $service, FindCitiesService $find)
    {
        $this->service = $service;
        $this->find = $find;
    }

    public function create(array $request)
    {
        $cities = $this->find->findCity(
            $request['departure_point'],
            $request['arrival_point']
        );

        $ticket = Ticket::create([
            'departure_point' => $cities['departure_point']->id,
            'arrival_point' => $cities['arrival_point']->id,
            'date' => $request['date'],
            'time' => $request['time'],
            'seat' => $request['seats'],
        ]);

        $ticket->cities()->attach($cities['departure_point']);
        $ticket->cities()->attach($cities['arrival_point']);

        $this->service->index($ticket);

        return $ticket;
    }

    public function update(Ticket $ticket)
    {
        $this->service->update($ticket);
    }

    public function delete(Ticket $ticket)
    {
        $this->service->delete($ticket);

        $ticketArray = $ticket->toArray();
        $ticketArray['departure_point'] = $ticket->departurePoint();
        $ticketArray['arrival_point'] = $ticket->arrivalPoint();

        $ticket->delete();

        return $ticketArray;
    }
}