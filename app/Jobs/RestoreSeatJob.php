<?php

namespace App\Jobs;

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
        if ($this->ticket && $this->user) {
            $this->restore();
        } elseif ($this->user && Redis::exists('order.' . $this->user->id)) {
            Redis::del('order.' . $this->user->id);
        }
    }

    private function restore()
    {
        if (Redis::exists('order.' . $this->user->id)
            && (int) Redis::get('order.' . $this->user->id) === $this->ticket->id)
        {
            Redis::del('order.' . $this->user->id);
            $this->ticket->update([
                'seat' => $this->ticket->seat + 1,
            ]);
        }
    }
}
