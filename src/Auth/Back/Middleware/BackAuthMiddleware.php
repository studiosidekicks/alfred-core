<?php

namespace Studiosidekicks\Alfred\Auth\Back\Middleware;

use Closure;
use Illuminate\Http\Request;
use Sentinel;

class BackAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Sentinel::check()) {
            return $next($request);
        }

        return response()->json(['message' => 'Access forbidden'], 403);
    }
}
