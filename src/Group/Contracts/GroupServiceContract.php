<?php

namespace Studiosidekicks\Alfred\Group\Contracts;

use Illuminate\Http\Request;
use Studiosidekicks\Alfred\Auth\Back\Entities\Role;

interface GroupServiceContract
{
    public function getAllGroups();

    public function createGroup(Request $request);

    public function updateGroup(Role $role, Request $request);

    public function deleteGroup(Role $role);

    public function getGroupData(Role $role);
}