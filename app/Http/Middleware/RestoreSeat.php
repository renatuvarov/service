<?php

namespace App\Http\Middleware;

use App\Entity\Ticket;
use Closure;
use Illuminate\Support\Facades\Redis;

class RestoreSeat
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $name = $request->route()->getName();
        $user = $request->user();

        if ($user && Redis::exists('order.' . $user->id)
            && !($name === 'tickets.order.form' || $name === 'tickets.order')
        ) {
            $ticket = Ticket::findOrFail(Redis::get('order.' . $user->id));

            Redis::del('order.' . $user->id);

            $ticket->update([
                'seat' => $ticket->seat + 1,
            ]);
        }
        return $next($request);
    }
}
