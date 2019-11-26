<?php
namespace Studiosidekicks\Alfred\Commands;

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
        $this->info('Publishing migrations...');
        Artisan::call('vendor:publish', [
            '--provider' => 'Studiosidekicks\Alfred\Providers\AlfredProvider',
            '--tag' => 'alfred-migrations'
        ]);

        $this->info('Migrating...');
        Artisan::call('migrate');

        $this->info('Creating primary CMS account...');

        $email = $this->ask('What is the email for primary account?');

        Artisan::call('alfred:setup-primary-account', [
            'email' => $email,
        ]);
        echo Artisan::output();

        $this->info('Installation has finished!');
    }
}