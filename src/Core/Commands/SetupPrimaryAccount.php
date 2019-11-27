<?php
namespace Studiosidekicks\Alfred\Core\Commands;

use Illuminate\Console\Command;
use BackAuth;
use Illuminate\Support\Facades\Validator;

class SetupPrimaryAccount extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'alfred:setup-primary-account';

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
        $this->info('Creating primary CMS account...');

        list($data, $error) = BackAuth::checkOtherPrimaryAccountExistence();

        if ($error || $data['exists']) {
            $this->error('Other primary account already exists.');
            return;
        }

        $primaryAccountEmail = $this->ask('What is the email for primary account?');

        $validator = Validator::make(['email' => $primaryAccountEmail], [
            'email' => 'required|email|unique:users|max:255',
        ]);

        if ($validator->fails()) {
            $this->error($validator->errors()->first('email'));
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