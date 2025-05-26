<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class AppSetup extends Command
{
    protected $signature = 'app:setup';

    protected $description = 'Run all necessary commands to setup app';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Artisan::call('key:generate');

        dump('Key generation ended.');

        exec('npm install');

        exec('npm run build');

        dump('Npm ended.');

        Artisan::call('migrate');

        dump('Migration ended.');

        Artisan::call('db:seed');

        dump('Seed ended.');
    }
}
