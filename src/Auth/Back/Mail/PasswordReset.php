<?php

namespace Studiosidekicks\Alfred\Auth\Back\Mail;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;

class PasswordReset extends Mailable implements ShouldQueue
{
    public $url;

    /**
     * Create a new message instance.
     *
     * @param $url
     */
    public function __construct($url)
    {
        $this->url = $url;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('Password Reset Link')
            ->view('alfred::emails.back.password-reset');
    }
}