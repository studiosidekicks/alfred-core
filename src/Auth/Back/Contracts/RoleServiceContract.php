<?php

namespace Studiosidekicks\Alfred\Auth\Back\Contracts;

interface RoleServiceContract
{
    public function get(array $columns = ['*']);
}
