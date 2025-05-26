<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class AppSetup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run all necessary commands to setup app';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        exec('npm install');

        exec('npm run build');

        dump('Npm ended.');

        Artisan::call('migrate');

        dump('Migration ended.');

        Artisan::call('db:seed');

        dump('Seed ended.');
    }
}
