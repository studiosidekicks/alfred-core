<?php

namespace Studiosidekicks\Alfred\User\Services;

use Illuminate\Http\Request;
use Studiosidekicks\Alfred\User\Contracts\MyAccountServiceContract;
use BackAuth;

class MyAccountService implements MyAccountServiceContract
{
    public function getDataAboutLoggedInUser()
    {
        $user = BackAuth::user();
        $userData = $user->only(['email', 'first_name', 'last_name', 'is_super_admin']);

        $userData['permissions'] = ['pages.index', 'pages.update', 'pages.publish'];

        return [[
            'data' => $userData,
        ], false];
    }

    public function getMyAccountData()
    {
        $user = BackAuth::user();

        $userData = $user->only(['email', 'first_name', 'last_name']);
        $userData['role_id'] = $user->roles()->first(['roles.id'])->role_id;

        return [[
            'data' => $userData,
        ], false];
    }

    public function updateMyAccountData(Request $request)
    {
        $user = BackAuth::user();

        $user->update($request->only(['email', 'first_name', 'last_name']));

        $user->roles()->sync($request->get('role_id'));

        return ['Account data updated successfully.', false];
    }
}