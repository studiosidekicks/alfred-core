<?php

namespace Studiosidekicks\Alfred\Auth\Back\Repositories;

use Studiosidekicks\Alfred\Auth\Back\Contracts\RoleRepositoryContract;
use Cartalyst\Sentinel\Roles\IlluminateRoleRepository;
use Studiosidekicks\Alfred\Auth\Back\Entities\Role;

class RoleRepository extends IlluminateRoleRepository implements RoleRepositoryContract
{
    /**
     * The Eloquent role model FQCN.
     *
     * @var string
     */
    protected $model = Role::class;
}