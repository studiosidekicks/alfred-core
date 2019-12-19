<?php

namespace Studiosidekicks\Alfred\FileManager\Services;

use Studiosidekicks\Alfred\FileManager\Contracts\DirectoriesRepositoryContract;
use Studiosidekicks\Alfred\FileManager\Contracts\DirectoriesServiceContract;
use Studiosidekicks\Alfred\FileManager\Entities\Directory;

class DirectoriesService implements DirectoriesServiceContract
{
    protected $repository;

    public function __construct(DirectoriesRepositoryContract $repository)
    {
        $this->repository = $repository;
    }
    
    public function getDirectoriesTree()
    {
        $tree = $this->repository->getListWithAllSubDirectories();
        return [['tree' => $tree], false];
    }

    public function createDirectory(array $dataFromRequest, $parentId = null)
    {
        if ($parentId) {
            $parentDirectory = $this->repository->findById($parentId);

            if (!$parentDirectory) {
                return ['Incorrect parent directory', true];
            }

            $createdDirectory = $parentDirectory->subdirectories()->create($dataFromRequest);
        } else {
            $createdDirectory = $this->repository->create($dataFromRequest);
        }

        if ($createdDirectory) {
            return [['message' => 'Directory created successfully.', 'data' => $createdDirectory], false];
        }

        return ['Directory could not be updated.', true];
    }

    public function updateDirectory(Directory $directory, array $dataFromRequest)
    {
        if ($directory->update($dataFromRequest)) {
            return ['Directory updated successfully.', false];
        }

        return ['Directory could not be updated.', true];
    }

    public function removeDirectory(Directory $directory)
    {
        if ($directory->delete()) {
            return ['Directory removed successfully.', false];
        }
        return ['Directory could not be removed.', true];
    }

    public function changeParentForDirectory(Directory $directory, $parentId)
    {
        if ($parentId) {
            $parentDirectory = $this->repository->findById($parentId);

            if (!$parentDirectory) {
                return ['Incorrect parent directory', true];
            }
        }

        if ($directory->update(['parent_id' => $parentId])) {
            return ['Directory moved successfully.', false];
        }

        return ['Directory could not be moved.', true];
    }

}