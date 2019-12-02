<?php

namespace Studiosidekicks\Alfred\Auth\Back\Events;

use Illuminate\Queue\SerializesModels;

class ResetPasswordStarted
{
    use SerializesModels;

    public $user, $reminder;

    /**
     * Create a new event instance.
     *
     * @param $user
     * @param $reminder
     */
    public function __construct($user, $reminder)
    {
        $this->user = $user;
        $this->reminder = $reminder;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return ['mail'];
    }
}