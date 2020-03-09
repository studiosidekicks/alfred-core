<?php
namespace Studiosidekicks\Alfred\Http\Controllers\User;

use Studiosidekicks\Alfred\Http\Controllers\ApiResponseController;
use Studiosidekicks\Alfred\User\Contracts\MyAccountServiceContract;
use Studiosidekicks\Alfred\User\Requests\UpdateMyAccountRequest;

class MyAccountApiController extends ApiResponseController
{
    protected $service;

    public function __construct(MyAccountServiceContract $service)
    {
        $this->service = $service;
    }

    public function getDataForEdit()
    {
        list($response, $error) = $this->service->getMyAccountData();
        return $this->response($response, $error);
    }

    public function getCurrentLoggedUserData()
    {
        list($response, $error) = $this->service->getDataAboutLoggedInUser();
        return $this->response($response, $error);
    }

    public function saveCurrentLoggedUserData(UpdateMyAccountRequest $request)
    {
        list($response, $error) = $this->service->updateMyAccountData($request);
        return $this->response($response, $error);
    }
}