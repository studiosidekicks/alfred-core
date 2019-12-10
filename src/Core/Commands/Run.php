<?php
namespace Studiosidekicks\Alfred\Core\Commands;

use Illuminate\Console\Command;

class Run extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'alfred:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Runs frontend';

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
        exec('npm install', $output);
        dd($output);
    }
}