<?php

namespace Studiosidekicks\Alfred\Log\Facades;

use Illuminate\Support\Facades\Facade;

class Error extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'alfred-errors';
    }
}