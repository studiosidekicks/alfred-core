<?php

namespace Studiosidekicks\Alfred\Auth\Back\Entities;

use Cartalyst\Sentinel\Users\EloquentUser;
use Illuminate\Support\Facades\Mail;
use Studiosidekicks\Alfred\Auth\Back\Events\ResetPasswordStarted;
use Illuminate\Notifications\Notifiable;
use Activation;
use Reminder;
use Studiosidekicks\Alfred\Auth\Back\Mail\PasswordReset;

class BackUser extends EloquentUser
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'is_primary',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'is_primary'
    ];

    protected $casts = [
        'is_primary' => 'boolean'
    ];
    /**
     * @return int
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function createActivation()
    {
        return Activation::create($this);
    }

    public function completeActivation()
    {
        $activationRecord = $this->activations()->where('completed', false)->first();

        if ($activationRecord) {
            Activation::complete($this, $activationRecord->code);
        }
    }

    public function sendReminder()
    {
        $reminder = $this->reminders()->where('completed', false)->first();

        if (!$reminder) {
            $reminder = Reminder::create($this);
        }

        event(new ResetPasswordStarted($this, $reminder));
    }

    public function checkReminderExists(string $code)
    {
        return $this->reminders()->where([
            'code' => $code,
            'completed' => false
        ])->exists();
    }

    public function completeResetPassword(string $code, string $password)
    {
        return Reminder::complete($this, $code, $password);
    }
}
