<?php

namespace Studiosidekicks\Alfred\Auth\Back\Repositories;

use Studiosidekicks\Alfred\Auth\Back\Contracts\RoleRepositoryContract;
use Cartalyst\Sentinel\Roles\IlluminateRoleRepository;
use Studiosidekicks\Alfred\Pagination\Services\PaginationHelper;

class RoleRepository extends IlluminateRoleRepository implements RoleRepositoryContract
{
    private $queryModel;

    public function __construct(string $model = null)
    {
        parent::__construct($model);
        $this->queryModel = app()->make($model);
    }

    public function get(array $columns = ['*'])
    {
        $paginationHelper = new PaginationHelper();
        return $paginationHelper->resolveQuery($this->queryModel, $columns);
    }

    public function create(array $data)
    {
        return $this->queryModel->create($data);
    }

    public function firstOrCreate(array $conditionsData)
    {
        return $this->queryModel->firstOrCreate($conditionsData);
    }

}
