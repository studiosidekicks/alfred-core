<?php

namespace Studiosidekicks\Alfred\Log\Entities;

use Studiosidekicks\Alfred\Core\Entities\AlfredModel;

class LogSigning extends AlfredModel
{
    protected $table = 'log_signings';

    protected $fillable = ['email', 'is_successful', 'message', 'ip'];

    protected $casts = [
        'is_successful' => 'boolean',
    ];
}