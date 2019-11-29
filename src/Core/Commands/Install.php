<?php
namespace Studiosidekicks\Alfred\Core\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Filesystem\Filesystem;
use Studiosidekicks\Alfred\Providers\RouteServiceProvider;

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

        $this->info('Adding RouteServiceProvider to config...');

        $this->writeAppConfigFile($this->getAlfredProvidersToBeRegisteredManually());

        $this->info('RouteServiceProvider added  successfully');

        Artisan::call('optimize');

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
}