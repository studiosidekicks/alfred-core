<?php

namespace Studiosidekicks\Alfred\Tests;

use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Cartalyst\Sentinel\Laravel\Facades\Reminder;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Cartalyst\Sentinel\Laravel\SentinelServiceProvider;
use Studiosidekicks\Alfred\Log\Facades\Signing;
use Studiosidekicks\Alfred\Providers\AlfredProvider;
use Studiosidekicks\Alfred\Providers\RouteServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

abstract class TestCase extends OrchestraTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->artisan('migrate');
        $this->withFactories(__DIR__ . '/../database/factories');
    }

    protected function getPackageProviders($app)
    {
        return  [
            AlfredProvider::class,
            RouteServiceProvider::class,
            SentinelServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'BackAuth' => 'Studiosidekicks\Alfred\Auth\Back\Facades\BackAuth',
            'Activation' => Activation::class,
            'Reminder' => Reminder::class,
            'Sentinel' => Sentinel::class,
            'Signing' => Signing::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'alfred_test');
        $app['config']->set('database.connections.alfred_test', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }

}