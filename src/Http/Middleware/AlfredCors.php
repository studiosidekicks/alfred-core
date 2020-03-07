<?php

namespace Studiosidekicks\Alfred\Http\Middleware;

use Closure;
use Fruitcake\Cors\HandleCors;

class AlfredCors extends HandleCors
{
    public function handle($request, Closure $next)
    {
        return parent::handle($request, $next);
    }

}