<?php

namespace Studiosidekicks\Alfred\User\Contracts;

use Illuminate\Http\Request;

interface MyAccountServiceContract
{
    public function getMyAccountData();

    public function getDataAboutLoggedInUser();

    public function updateMyAccountData(Request $request);

}