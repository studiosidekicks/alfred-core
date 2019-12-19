<?php

namespace Studiosidekicks\Alfred\FileManager\Contracts;

use Studiosidekicks\Alfred\FileManager\Entities\Directory;

interface DirectoriesServiceContract
{
    public function getDirectoriesTree();

    public function createDirectory(array $dataFromRequest, $parentId = null);

    public function updateDirectory(Directory $directory, array $dataFromRequest);

    public function removeDirectory(Directory $directory);

    public function changeParentForDirectory(Directory $directory, $parentId);
}