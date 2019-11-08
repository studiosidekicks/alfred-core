<?php

namespace Studiosidekicks\Alfred\Auth\Back\Repositories;

use Studiosidekicks\Alfred\Auth\Back\Contracts\UserRepositoryContract;
use Cartalyst\Sentinel\Users\IlluminateUserRepository;
use Studiosidekicks\Alfred\Auth\Back\Entities\BackUser;

class UserRepository extends IlluminateUserRepository implements UserRepositoryContract
{
    /**
     * The User model FQCN.
     *
     * @var string
     */
    protected $model = BackUser::class;
}