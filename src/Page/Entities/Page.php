<?php

namespace Studiosidekicks\Alfred\Page\Entities;

use Studiosidekicks\Alfred\Core\Entities\AlfredModel;
use Studiosidekicks\Alfred\Core\Traits\Publishable;

class Page extends AlfredModel
{
    use Publishable;

    protected $table = 'pages';
}