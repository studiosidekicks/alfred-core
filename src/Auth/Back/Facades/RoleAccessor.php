<?php

namespace Studiosidekicks\Alfred\Auth\Back\Facades;

use \Illuminate\Support\Facades\Facade;

class RoleAccessor extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'studiosidekicks.alfred.role_accessor';
    }
}
