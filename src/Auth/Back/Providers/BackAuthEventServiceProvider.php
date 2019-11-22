<?php

namespace Studiosidekicks\Alfred\Auth\Back\Providers;

use Studiosidekicks\Alfred\Auth\Back\Events\ResetPasswordStarted;
use Studiosidekicks\Alfred\Auth\Back\Listeners\SendReminderEmail;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class BackAuthEventServiceProvider extends ServiceProvider
{
    protected $listen = [
        ResetPasswordStarted::class => [
            SendReminderEmail::class,
        ],
    ];
}