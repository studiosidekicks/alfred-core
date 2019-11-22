<?php

namespace Studiosidekicks\Alfred\Auth\Back\Observers;

use Studiosidekicks\Alfred\Auth\Back\Entities\BackUser;

class BackUserObserver
{
    public function created(BackUser $backUser)
    {
        $backUser->createActivation();
    }
}