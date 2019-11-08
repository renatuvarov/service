<?php

namespace App\Jobs;

use App\Entity\Ticket;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Redis;

class RestoreSeatJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $ticket;
    private $user;

    public function __construct($ticket, $user)
    {
        $this->ticket = $ticket;
        $this->user = $user;
    }

    public function handle()
    {
        $ticket = Ticket::find($this->ticket);
        $user = User::find($this->user);

        if ($ticket && $user) {
            $this->restore($ticket, $user);
        } elseif ($user && Redis::exists('order.' . $user->id)) {
            Redis::del('order.' . $user->id);
        }
    }

    private function restore($ticket, $user)
    {
        if (Redis::exists('order.' . $user->id)
            && (int) Redis::get('order.' . $user->id) === $ticket->id)
        {
            Redis::del('order.' . $user->id);
            $ticket->update([
                'seat' => $ticket->seat + 1,
            ]);
        }
    }
}
