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

        $userData['permissions'] = [
            'dashboard.index',
            'admin-tools.index',
            'admin-tools.groups',
            'admin-tools.cms-users',
            'admin-tools.cms-signins',
            'admin-tools.cms-operations',
            'admin-tools.error-logs',
            'website-tools.index',
            'website-tools.scripts',
            'website-tools.website-users',
            'website-tools.languages',
        ];

        return [[
            'data' => $userData,
        ], false];
    }

    public function getMyAccountData()
    {
        $user = BackAuth::user();

        $userData = $user->only(['email', 'first_name', 'last_name']);
        $userData['role_id'] = $user->roles()->first(['roles.id'])->id;

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
