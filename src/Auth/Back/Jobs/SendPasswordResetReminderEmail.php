<?php

namespace Studiosidekicks\Alfred\Auth\Back\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Studiosidekicks\Alfred\Auth\Back\Mail\PasswordReset;

class SendPasswordResetReminderEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $email;
    private $reminderUrl;

    public function __construct($email, $userId, $reminderCode)
    {
        $this->email = $email;
        $this->reminderUrl = url('cms/reset/' . $reminderCode . '/' . $userId);
    }

    public function handle()
    {
        Mail::to($this->email)->send(new PasswordReset($this->reminderUrl));
    }
}