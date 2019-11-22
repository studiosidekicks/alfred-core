<?php

namespace Studiosidekicks\Alfred\Auth\Front\Facades;

use \Illuminate\Support\Facades\Facade;

class FrontAuth extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'studiosidekicks.alfred.front_auth';
    }
}