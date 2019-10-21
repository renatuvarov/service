<?php

namespace App\Http\Middleware;

use Closure;

class Ajax
{
    public function handle($request, Closure $next)
    {
        if ($request->isXmlHttpRequest()) {
            return $next($request);
        }

        abort(404);
    }
}
