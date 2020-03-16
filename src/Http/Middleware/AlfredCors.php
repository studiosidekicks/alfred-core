<?php

namespace Studiosidekicks\Alfred\Http\Middleware;

use Closure;

class AlfredCors
{
    public function handle($request, Closure $next)
    {
        $config = config('studiosidekicks.cors');

        return $next($request)
            ->header('Access-Control-Allow-Origin', $config['allowed_origins'])
            ->header('Access-Control-Allow-Methods', $config['allowed_methods']);
    }

}