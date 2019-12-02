<?php

namespace Studiosidekicks\Alfred\Log\Facades;

use Illuminate\Support\Facades\Facade;

class Signing extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'alfred-signings';
    }
}