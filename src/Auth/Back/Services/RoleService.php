<?php

namespace Studiosidekicks\Alfred\Auth\Back\Services;

use Studiosidekicks\Alfred\Auth\Back\Contracts\RoleRepositoryContract;
use Studiosidekicks\Alfred\Auth\Back\Contracts\RoleServiceContract;

class RoleService implements RoleServiceContract
{
    private $rolesRepository;

    public function __construct(RoleRepositoryContract $rolesRepository) {
        $this->rolesRepository = $rolesRepository;
    }

    public function get(array $columns = ['*'])
    {
        return [['list' => $this->rolesRepository->get($columns)], false];
    }
}
