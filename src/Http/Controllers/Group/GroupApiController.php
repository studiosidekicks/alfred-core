<?php

namespace Studiosidekicks\Alfred\Http\Controllers\Group;

use Studiosidekicks\Alfred\Auth\Back\Entities\Role;
use Studiosidekicks\Alfred\Group\Contracts\GroupServiceContract;
use Studiosidekicks\Alfred\Group\Requests\GroupRequest;
use Studiosidekicks\Alfred\Http\Controllers\ApiResponseController;

class GroupApiController extends ApiResponseController
{
    protected $service;

    public function __construct(GroupServiceContract $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        list($response, $error) = $this->service->getAllGroups();
        return $this->response($response, $error);
    }

    public function store(GroupRequest $request)
    {
        list($response, $error) = $this->service->createGroup($request);
        return $this->response($response, $error);
    }

    public function update(GroupRequest $request, Role $role)
    {
        list($response, $error) = $this->service->updateGroup($role, $request);
        return $this->response($response, $error);
    }

    public function edit(Role $role)
    {
        list($response, $error) = $this->service->getGroupData($role);
        return $this->response($response, $error);
    }

    public function destroy(Role $role)
    {
        list($response, $error) = $this->service->deleteGroup($role);
        return $this->response($response, $error);
    }
}