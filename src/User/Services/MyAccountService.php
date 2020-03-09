<?php

namespace Studiosidekicks\Alfred\User\Services;

use Illuminate\Http\Request;
use Studiosidekicks\Alfred\User\Contracts\MyAccountServiceContract;
use BackAuth;

class MyAccountService implements MyAccountServiceContract
{
    public function getMyAccountData()
    {
        $user = BackAuth::user();

        $userData = $user->only(['email', 'first_name', 'last_name']);
        
        // tmp
        $userData['roles'] = ['superadmin'];
        $userData['permissions'] = ['pages.index', 'pages.update', 'pages.publish'];

        return [[
            'data' => $userData,
        ], false];
    }

    public function updateMyAccountData(Request $request)
    {
        $user = BackAuth::user();

        $user->update($request->only(['email', 'first_name', 'last_name']));

        return ['Account data updated successfully.', false];
    }
}