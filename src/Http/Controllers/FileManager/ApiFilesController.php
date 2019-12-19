<?php

namespace Studiosidekicks\Alfred\Http\Controllers\FileManager;

use Studiosidekicks\Alfred\FileManager\Contracts\FilesServiceContract;
use Studiosidekicks\Alfred\Http\Controllers\ApiResponseController;

class ApiFilesController extends ApiResponseController
{
    protected $service;

    public function __construct(FilesServiceContract $service)
    {
        $this->service = $service;
    }
}