<?php

namespace App\Console\Commands\Search;

use App\Entity\Ticket;
use App\Http\Services\Elasticsearch\TicketService;
use Elasticsearch\Common\Exceptions\Missing404Exception;
use Illuminate\Console\Command;

class Tickets extends Command
{
    protected $signature = 'search:tickets';
    protected $description = 'Command description';
    private $service;

    public function __construct(TicketService $service)
    {
        parent::__construct();
        $this->service = $service;
    }

    public function handle()
    {
        try {
            $this->service->deleteIndex();
        } catch (Missing404Exception $e) {}

        $this->service->createIndex();

        foreach (Ticket::with('cities')->cursor() as $ticket) {
            $this->service->index($ticket);
        }

        return true;
    }
}
