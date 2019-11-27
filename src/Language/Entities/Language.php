<?php

namespace Studiosidekicks\Alfred\Language\Entities;

use Studiosidekicks\Alfred\Core\Entities\AlfredModel;

class Language extends AlfredModel
{
    protected $table = 'languages';
    protected $fillable = [
        'name',
        'code',
        'slug',
        'hreflang',
    ];
}