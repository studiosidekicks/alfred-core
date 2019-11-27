<?php

namespace Studiosidekicks\Alfred\Auth\Back\Contracts;

interface BackAuthServiceContract
{
    public function checkOtherPrimaryAccountExistence();

    public function createPrimaryAccount(string $email);

    public function login(string $email, string $password, bool $rememberMe);
}