<?php

namespace Studiosidekicks\Alfred\Language\Entities;

use Studiosidekicks\Alfred\Core\Entities\AlfredModel;

class Language extends AlfredModel
{
    protected $table = 'languages';
    protected $fillable = [
        'name',
        'slug',
        'hreflang',
        'is_primary_language',
    ];

    protected $casts = [
        'is_primary_language' => 'boolean'
    ];
}