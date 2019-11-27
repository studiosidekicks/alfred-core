<?php

namespace Studiosidekicks\Alfred\Http\Controllers\Dashboard;

use Studiosidekicks\Alfred\Dashboard\Contracts\DashboardServiceContract;
use Studiosidekicks\Alfred\Http\Controllers\ApiResponseController;

class ApiController extends ApiResponseController
{
    protected $service;

    public function __construct(DashboardServiceContract $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return $this->response('Some api response here');
    }
}