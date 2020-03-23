<?php
namespace Studiosidekicks\Alfred\Core\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Validator;
use Studiosidekicks\Alfred\Language\Entities\Language;
use Studiosidekicks\Alfred\Providers\RouteServiceProvider;
use BackAuth;

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

        $this->publishAndRunMigrations();

        $this->addRouteServiceProvider();

        $this->setupPrimaryAccount();

        $this->setupPrimaryLanguage();

        $this->info('Installation has finished!');
    }

    private function writeAppConfigFile(array $providers)
    {
        if (empty($providers)) {
            return;
        }

        $appConfig = "";
        $configPath = base_path('/config/app.php');
        $scriptIsInProviders = false;

        foreach (file($configPath) as $line) {

            if (trim(preg_replace('/[\t\s]+/', '', $line)) == "'providers'=>[") {
                $scriptIsInProviders =  true;
            }

            if ($scriptIsInProviders) {

                if (trim(preg_replace('/[\t\s]+/', '', $line)) == "],") {
                    $scriptIsInProviders = false;

                    $line = $this->getWriteableServiceProviders($providers) . $line;
                }
            }

            $appConfig .= $line;
        }

        $fileSystem = new Filesystem();
        $fileSystem->put($configPath, $appConfig);
    }

    private function getWriteableServiceProviders($providers)
    {
        $content = "";

        foreach($providers as $provider) {
            $content .= "\t\t$provider::class," . PHP_EOL;
        }
        return $content;
    }

    private function getAlfredProvidersToBeRegisteredManually()
    {
        $providers = config('app.providers');
        $providersToAdd = [
            RouteServiceProvider::class
        ];

        $filtered = [];

        foreach ($providersToAdd as $singleProvider) {

            if (!in_array($singleProvider, $providers))  {
                $filtered[] = $singleProvider;
            }
        }
        return $filtered;
    }

    private function setupPrimaryLanguage()
    {

        $this->info('Primary Language Settings...');

        if (Language::where('is_primary_language', true)->exists()) {
            $this->error('Primary language already exists!');
            return;
        }

        $languageName = $this->ask('What is language name?', 'English');
        $languageSlug = $this->ask('What should be language slug?');
        $languageHreflang = $this->ask('What is language hreflang attribute value?', 'en');

        Language::create([
            'name' => $languageName,
            'slug' => $languageSlug,
            'hreflang' => $languageHreflang,
            'is_primary_language' => true,
        ]);

        $this->info('Language setup finished');
    }

    public function setupPrimaryAccount()
    {
        $this->info('Creating primary CMS account...');

        BackAuth::createMainAdminGroup();
        list($data, $error) = BackAuth::checkOtherPrimaryAccountExistence();

        if ($error || $data['exists']) {
            $this->error('Other primary account already exists.');
            return;
        }

        $primaryAccountEmail = $this->askForEmail();
        $firstName = $this->askForName('First name', 'Super');
        $lastName = $this->askForName('Last name', 'Admin');

        $password = BackAuth::createPrimaryAccount($primaryAccountEmail, $firstName, $lastName);

        if ($password) {
            $this->alert('Generated password for the user:');
            $this->info($password);
            return;
        }

        $this->error('Account has not been setup.');
        return;
    }

    private function askForEmail()
    {
        $primaryAccountEmail = $this->ask('What is the email for primary account?');

        $validator = Validator::make(['email' => $primaryAccountEmail], [
            'email' => 'required|email|unique:users|max:255',
        ]);

        if ($validator->fails()) {
            $this->error($validator->errors()->first('email'));

            $this->askForEmail();
        }

        return $primaryAccountEmail;
    }

    private function addRouteServiceProvider()
    {
        $this->info('Adding RouteServiceProvider to config...');

        $this->writeAppConfigFile($this->getAlfredProvidersToBeRegisteredManually());

        $this->info('RouteServiceProvider added successfully');

        Artisan::call('optimize');
    }

    private function publishAndRunMigrations()
    {
        Artisan::call('alfred:publish-migrations');

        echo Artisan::output();

        $this->info('Migrating...');

        Artisan::call('migrate');

        echo Artisan::output();
    }

    private function askForName($stringPrefix, $default)
    {
        return $this->ask($stringPrefix . ' for primary account?', $default);
    }
}
