<?php

namespace Studiosidekicks\Alfred\Auth\Back\Services;

use Illuminate\Support\Facades\DB;
use Studiosidekicks\Alfred\Auth\Back\Contracts\BackAuthServiceContract;
use Studiosidekicks\Alfred\Auth\Back\Contracts\RoleRepositoryContract;
use Studiosidekicks\Alfred\Auth\Back\Contracts\UserRepositoryContract;
use Sentinel;

class BackAuthService implements BackAuthServiceContract
{
    private $usersRepository;
    private $rolesRepository;

    public function __construct(
        UserRepositoryContract $usersRepository,
        RoleRepositoryContract $rolesRepository
    ) {
        $this->usersRepository = $usersRepository;
        $this->rolesRepository = $rolesRepository;
    }

    public function checkOtherPrimaryAccountExistence()
    {
        return [['exists' => $this->usersRepository->checkExistenceOfPrimaryAccount()], false];
    }

    public function createPrimaryAccount(string $email)
    {
        $password = $this->generatePassword();
        $data = [
            'email' => $email,
            'password' => $password,
        ];

        DB::beginTransaction();

        try {
            if ($createdUser = $this->usersRepository->create($data)) {

                $createdUser->update([
                    'is_primary' => 1,
                ]);

                $createdUser->completeActivation();
            }

        } catch (\Exception $exception) {
            DB::rollBack();
            \Log::error($exception);
            return false;
        }

        DB::commit();
        return $password;
    }

    public function login(string $email, string $password, bool $rememberMe)
    {
        if (Sentinel::authenticate(compact('email', 'password'), $rememberMe)) {

            return ['You have successfully logged in', false];
        }

        return ['Invalid credentials', true];
    }

    public function logout()
    {
        if (Sentinel::logout()) {
            return ['You have been successfully logout.', false];
        }

        return ['Error during logging out.', true];
    }

    public function sendPasswordReminder(string $email)
    {
        if ($user = $this->usersRepository->findByEmail($email)) {
            $user->sendReminder();
            return ['Reminder email has been sent.', false];
        }

        return ['User not found', true];
    }

    public function verifyPasswordResetData(string $code, int $userId)
    {
        if ($this->checkReminderExists($code, $userId)) {
            return ['Url is correct.', false];
        }
        return ['The url you entered is incorrect.',  true];
    }

    public function resetPassword(string $code, int $userId, string $password)
    {
        if ($user = $this->checkReminderExists($code, $userId)) {

            if ($user->completeResetPassword($code, $password)) {
                return ['Password changed successfully.', false];
            }

            return ['Password could not be changed.', true];

        }

        return ['The url you entered is incorrect.',  true];
    }

    private function checkReminderExists(string $code, int $userId)
    {
        if ($user = $this->usersRepository->findById($userId)) {

            if ($user->checkReminderExists($code)) {
                return $user;
            }
        }

        return false;
    }

    private function generatePassword()
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890!@#$%^&*()';
        $charactersLength = strlen($characters);
        $randomString = '';

        for ($i = 0; $i < 20; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }
}