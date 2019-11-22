<?php

namespace Studiosidekicks\Alfred\Auth\Back\Repositories;

use Studiosidekicks\Alfred\Auth\Back\Contracts\UserRepositoryContract;
use Cartalyst\Sentinel\Users\IlluminateUserRepository;

class UserRepository extends IlluminateUserRepository implements UserRepositoryContract
{

    private function model()
    {
        return app()->make(config('studiosidekicks.alfred.auth.back.model'));
    }

    public function checkExistenceOfPrimaryAccount(string $email)
    {
        return $this->model()->whereEmail($email)->orWhere('is_primary', 1)->exists();
    }

    public function findByEmail(string $email)
    {
        return $this->model()->whereEmail($email)->first(['id', 'email']);
    }

}