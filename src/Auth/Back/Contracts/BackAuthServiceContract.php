<?php

namespace Studiosidekicks\Alfred\Auth\Back\Contracts;

interface BackAuthServiceContract
{
    public function checkOtherPrimaryAccountExistence();

    public function createPrimaryAccount(string $email, string $firstName, string $lastName);

    public function login(string $email, string $password, bool $rememberMe);
}
