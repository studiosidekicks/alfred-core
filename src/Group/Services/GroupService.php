<?php

namespace Studiosidekicks\Alfred\Group\Services;

use Illuminate\Http\Request;
use Studiosidekicks\Alfred\Auth\Back\Contracts\RoleRepositoryContract;
use Studiosidekicks\Alfred\Auth\Back\Entities\Role;
use Studiosidekicks\Alfred\Group\Contracts\GroupServiceContract;

class GroupService implements GroupServiceContract
{
    protected $repository;

    public function __construct(RoleRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    public function getAllGroups()
    {
        $groups = $this->repository->get(['id', 'name']);
        return [['list' => $groups], false];
    }

    public function createGroup(Request $request)
    {
        $createdGroup = $this->repository->create($request->only(['name', 'permissions']));
        return [[
            'message' => 'Group has been created successfully.',
            'data' => $createdGroup,
        ], false];
    }

    public function updateGroup(Role $role, Request $request)
    {
        if ($role->update($request->only(['data', 'permissions']))) {
            return ['Group updated successfully.', false];
        }

        return ['Group could not be updated.', true];
    }

    public function deleteGroup(Role $role)
    {
        if ($role->delete()) {
            return ['Group has been removed.', false];
        }

        return ['Group could not be removed.', true];
    }

}