<?php

namespace Studiosidekicks\Alfred\FileManager\Repositories;

use Studiosidekicks\Alfred\FileManager\Contracts\DirectoriesRepositoryContract;
use Studiosidekicks\Alfred\FileManager\Entities\Directory;

class DirectoriesRepository implements DirectoriesRepositoryContract
{
    private $model;

    public function __construct()
    {
        $this->model = app()->make(Directory::class);
    }

    public function getListWithAllSubDirectories()
    {
        return $this->model->whereNull('parent_id')->with('allSubdirectories')->get(['id', 'name', 'parent_id']);
    }

    public function findById($itemId)
    {
        return $this->model->whereId($itemId)->first();
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

}