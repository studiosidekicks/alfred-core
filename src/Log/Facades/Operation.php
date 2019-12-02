<?php

namespace Studiosidekicks\Alfred\Log\Facades;

use Illuminate\Support\Facades\Facade;

class Operation extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'alfred-operations';
    }
}