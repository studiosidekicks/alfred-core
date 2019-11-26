<?php
namespace Studiosidekicks\Alfred\Commands;

use Illuminate\Console\Command;
use BackAuth;

class SetupPrimaryAccount extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'alfred:setup-primary-account {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setups main user for Alfred CMS';

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
        $primaryAccountEmail = $this->argument('email');

        if (empty($primaryAccountEmail)) {
            $this->error('No primary account email provided');
            return;
        }

        list($data, $error) = BackAuth::otherPrimaryAccountExists($primaryAccountEmail);

        if ($error || $data['exists']) {
            $this->error('Other primary account already exists.');
            return;
        }

        $password = BackAuth::createPrimaryAccount($primaryAccountEmail);

        if ($password) {
            $this->info($password);
            return;
        }

        $this->error('Account has not been setup.');
        return;
    }
}