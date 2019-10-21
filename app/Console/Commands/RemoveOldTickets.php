<?php

namespace App\Console\Commands;

use App\Entity\Ticket;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class RemoveOldTickets extends Command
{
    protected $signature = 'tickets:remove';

    protected $description = 'Remove old tickets';

    public function handle()
    {
        $ids = Ticket::where('date', '<', Carbon::now()->format('Y:m:d'))->pluck('id')->toArray();
        if (! empty($ids)) {
            Ticket::destroy($ids);
        }
    }
}
