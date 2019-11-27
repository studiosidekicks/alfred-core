<?php
namespace Studiosidekicks\Alfred\Core\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class PublishMigrations extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'alfred:publish-migrations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publishes migrations';

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
        $this->info('Publishing migrations...');

        Artisan::call('vendor:publish', [
            '--provider' => 'Studiosidekicks\Alfred\Providers\AlfredProvider',
            '--tag' => 'alfred-migrations'
        ]);

        $this->info('Publishing migrations has finished!');
    }
}