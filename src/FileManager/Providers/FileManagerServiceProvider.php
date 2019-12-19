<?php

namespace Studiosidekicks\Alfred\FileManager\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Studiosidekicks\Alfred\FileManager\Contracts\DirectoriesServiceContract;
use Studiosidekicks\Alfred\FileManager\Contracts\FilesServiceContract;
use Studiosidekicks\Alfred\FileManager\Repositories\DirectoriesRepository;
use Studiosidekicks\Alfred\FileManager\Services\DirectoriesService;
use Studiosidekicks\Alfred\FileManager\Services\FilesService;

class FileManagerServiceProvider extends ServiceProvider
{
    public function boot(Router $router)
    {
        //
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(FilesServiceContract::class, FilesService::class);

        $this->app->bind(DirectoriesServiceContract::class, function () {
            return new DirectoriesService(new DirectoriesRepository());
        });
    }

    /**
     * {@inheritdoc}
     */
    public function provides()
    {
        return [];
    }
}