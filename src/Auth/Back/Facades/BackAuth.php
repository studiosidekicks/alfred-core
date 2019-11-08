<?php

namespace Studiosidekicks\Alfred\Auth\Back\Facades;

use \Illuminate\Support\Facades\Facade;

class BackAuth extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'studiosidekicks.back_auth';
    }
}