<?php

namespace Studiosidekicks\Alfred\Core\Entities;

use Illuminate\Database\Eloquent\Model;
use Studiosidekicks\Alfred\Core\Contracts\AlfredModelContract;
use Studiosidekicks\Alfred\Log\Entities\LogOperation;

class AlfredModel extends Model implements AlfredModelContract
{
    public function operations()
    {
        return $this->morphMany(LogOperation::class, 'operationable');
    }

}