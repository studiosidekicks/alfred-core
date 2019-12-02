<?php

namespace Studiosidekicks\Alfred\Auth\Back\Listeners;

use Illuminate\Support\Facades\Mail;
use Studiosidekicks\Alfred\Auth\Back\Events\ResetPasswordStarted;
use Studiosidekicks\Alfred\Auth\Back\Mail\PasswordReset;

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
        $reminderUrl = url('cms/reset/' . $event->reminder->code . '/' . $event->user->id);

        $message = (new PasswordReset($reminderUrl))->onQueue('emails');

        Mail::to($event->user->email)->queue($message);
    }
}