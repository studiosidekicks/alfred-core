<?php

namespace Studiosidekicks\Alfred\Auth\Back\Contracts;

interface RoleRepositoryContract
{
    public function get(array $columns = ['*']);

    public function create(array $data);

    public function firstOrCreate(array $conditionsData);
}
