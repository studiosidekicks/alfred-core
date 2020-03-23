<?php

namespace Studiosidekicks\Alfred\Auth\Back\Services;

use Cartalyst\Sentinel\Checkpoints\ThrottlingException;
use Illuminate\Support\Facades\DB;
use Studiosidekicks\Alfred\Auth\Back\Contracts\BackAuthServiceContract;
use Studiosidekicks\Alfred\Auth\Back\Contracts\RoleRepositoryContract;
use Studiosidekicks\Alfred\Auth\Back\Contracts\UserRepositoryContract;
use Sentinel;
use Signing;

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

    public function createMainAdminGroup()
    {
        $this->rolesRepository->firstOrCreate([
            'name' => 'Admins',
            'slug' => 'admins'
        ]);
    }

    public function checkOtherPrimaryAccountExistence()
    {
        if ($exists = $this->usersRepository->checkExistenceOfPrimaryAccount()) {
            $primaryAccount = $this->usersRepository->getPrimaryAccount();

            if (!$primaryAccount->roles()->exists()) {
                $primaryAccount->roles()->attach(1);
            }
        }

        return [['exists' => $exists], false];
    }

    public function createPrimaryAccount(string $email, string $firstName, string $lastName)
    {
        $password = $this->generatePassword();
        $data = [
            'email' => $email,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'password' => $password,
            'is_super_admin' => true,
        ];

        DB::beginTransaction();

        try {
            $createdGroup = $this->rolesRepository->firstOrCreate([
                'name' => 'Admins'
            ]);

            if ($createdUser = $this->usersRepository->create($data)) {

                $createdUser->update([
                    'is_primary' => 1,
                ]);

                $createdUser->completeActivation();

                $createdGroup->users()->attach($createdUser->id);
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
        try {
            if (Sentinel::authenticate(compact('email', 'password'), $rememberMe)) {

                Signing::insert($email);
                return ['You have successfully logged in', false];
            }
        } catch (ThrottlingException $exception) {
            $errorMessage = $exception->getMessage();
        } catch (\Exception $exception) {
            $errorMessage = $exception->getMessage();
        }

        $errorMessage = !empty($errorMessage) ? $errorMessage : 'Invalid credentials';
        Signing::insert($email, $errorMessage);

        return [$errorMessage, true];
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

    public function user()
    {
        return Sentinel::getUser();
    }
}
