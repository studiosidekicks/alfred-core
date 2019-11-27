<?php

namespace Studiosidekicks\Alfred\Auth\Back\Contracts;

interface UserRepositoryContract
{
    public function checkExistenceOfPrimaryAccount();

    public function findByEmail(string $email);

    public function findById(int $userId);
}