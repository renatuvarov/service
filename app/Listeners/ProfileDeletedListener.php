<?php

namespace App\Listeners;

use App\Entity\Ticket;
use App\Events\ProfileDeleted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\DB;

class ProfileDeletedListener implements ShouldQueue
{
    public function handle(ProfileDeleted $event)
    {
        if (! empty($event->tickets)) {
            $tickets = Ticket::whereIn('id', $event->tickets)->get();

            if ($tickets->count() > 0) {
                $result = $this->query($tickets);
                DB::update($result['query'], $result['params']);
            }
        }
    }

    private function query($tickets): array
    {
        $table = Ticket::getModel()->getTable();

        $cases = [];
        $ids = [];
        $params = [];

        foreach ($tickets as $ticket) {
            $id = $ticket->id;
            $cases[] = "when {$id} then ?";
            $params[] = $ticket->seat + 1;
            $ids[] = $id;
        }

        $ids = implode(',', $ids);
        $cases = implode(' ', $cases);

        return [
            'query' => "UPDATE `{$table}` SET `seat` = CASE `id` {$cases} END WHERE `id` in ({$ids})",
            'params' => $params,
        ];
    }
}
