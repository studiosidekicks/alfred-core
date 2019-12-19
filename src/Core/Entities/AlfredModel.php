<?php

namespace Studiosidekicks\Alfred\Core\Entities;

use Illuminate\Database\Eloquent\Model;
use Studiosidekicks\Alfred\Core\Contracts\AlfredModelContract;
use Studiosidekicks\Alfred\Log\Traits\Operationable;

class AlfredModel extends Model implements AlfredModelContract
{
    use Operationable;

}