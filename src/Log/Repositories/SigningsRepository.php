<?php

namespace Studiosidekicks\Alfred\Log\Repositories;

use Studiosidekicks\Alfred\Log\Contracts\SigningsRepositoryContract;
use Studiosidekicks\Alfred\Log\Entities\LogSigning;

class SigningsRepository implements SigningsRepositoryContract
{
    private $model;

    public function __construct()
    {
        $this->model = app()->make(LogSigning::class);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

}