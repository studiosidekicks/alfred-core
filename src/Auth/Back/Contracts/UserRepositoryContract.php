<?php

namespace Studiosidekicks\Alfred\Auth\Back\Contracts;

interface UserRepositoryContract
{
    public function checkExistenceOfPrimaryAccount(string $email);

    public function findByEmail(string $email);

    public function findById(int $userId);
}