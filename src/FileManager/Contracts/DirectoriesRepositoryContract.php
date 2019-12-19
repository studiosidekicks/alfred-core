<?php

namespace Studiosidekicks\Alfred\FileManager\Contracts;

interface DirectoriesRepositoryContract
{
    public function getListWithAllSubDirectories();

    public function findById($itemId);

    public function create(array $data);
}