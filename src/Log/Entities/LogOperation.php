<?php

namespace Studiosidekicks\Alfred\Log\Entities;

use Illuminate\Database\Eloquent\Model;

class LogOperation extends Model
{
    protected $table = 'log_operations';
    protected $fillable = ['language_id', 'email', 'action', 'user_id'];

    public function item()
    {
        return $this->morphTo();
    }
}