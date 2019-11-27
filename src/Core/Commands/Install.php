<?php
namespace Studiosidekicks\Alfred\Core\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class Install extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'alfred:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Does required actions after Alfred package installation';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Installation of Alfred has started!');

        Artisan::call('alfred:publish-migrations');
        echo Artisan::output();

        $this->info('Migrating...');
        Artisan::call('migrate');
        echo Artisan::output();

        Artisan::call('alfred:setup-primary-account');
        echo Artisan::output();

        $this->info('Installation has finished!');
    }
}