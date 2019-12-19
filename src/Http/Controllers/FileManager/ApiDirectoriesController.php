<?php

namespace Studiosidekicks\Alfred\Http\Controllers\FileManager;

use Studiosidekicks\Alfred\FileManager\Contracts\DirectoriesServiceContract;
use Studiosidekicks\Alfred\FileManager\Entities\Directory;
use Studiosidekicks\Alfred\FileManager\Requests\CreateDirectoryRequest;
use Studiosidekicks\Alfred\FileManager\Requests\MoveDirectoryRequest;
use Studiosidekicks\Alfred\FileManager\Requests\UpdateDirectoryRequest;
use Studiosidekicks\Alfred\Http\Controllers\ApiResponseController;

class ApiDirectoriesController extends ApiResponseController
{
    protected $service;

    public function __construct(DirectoriesServiceContract $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        list($response, $error) = $this->service->getDirectoriesTree();
        return $this->response($response, $error);
    }

    public function store(CreateDirectoryRequest $request)
    {
        list($response, $error) = $this->service->createDirectory($request->only(['name']), $request->get('parent_id'));
        return $this->response($response, $error);
    }

    public function update(UpdateDirectoryRequest $request, Directory $directory)
    {
        list($response, $error) = $this->service->updateDirectory($directory, $request->only(['name']));
        return $this->response($response, $error);
    }

    public function move(MoveDirectoryRequest $request, Directory $directory)
    {
        list($response, $error) = $this->service->changeParentForDirectory($directory, $request->get('parent_id'));
        return $this->response($response, $error);
    }

    public function destroy(Directory $directory)
    {
        list($response, $error) = $this->service->removeDirectory($directory);
        return $this->response($response, $error);
    }
}