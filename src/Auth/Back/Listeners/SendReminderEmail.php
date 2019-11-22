<?php

namespace Studiosidekicks\Alfred\Auth\Back\Listeners;

use Studiosidekicks\Alfred\Auth\Back\Events\ResetPasswordStarted;
use Studiosidekicks\Alfred\Auth\Back\Jobs\SendPasswordResetReminderEmail;

class SendReminderEmail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param ResetPasswordStarted $event
     * @return void
     */
    public function handle(ResetPasswordStarted $event)
    {
        dispatch(new SendPasswordResetReminderEmail($event->user->email, $event->user->id, $event->reminder->code))
            ->onQueue('emails');
    }
}