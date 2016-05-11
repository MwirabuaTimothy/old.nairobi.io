<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AppInstall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setting up your app for the first time.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
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
        $this->comment('=====================================');
        $this->comment('');
        $this->comment('Preparing your application...');
        $this->comment('');
        $this->call('db:drop');
        $this->call('db:create');
        $this->askGenerateKey();
        $this->askInstallMigrate();
    }

    protected function askGenerateKey()
    {
        // Ask the user whether to generate key
        $ans = $this->ask('Generate App key?: ', 'y');

        // Check if the answer is true
        if (preg_match('/^y/', $ans))
        {
            // Generate the Application Encryption key
            $this->call('key:generate');
        }
    }

    protected function askInstallMigrate()
    {
        // Ask the user whether to run the resr
        $ans = $this->ask('Create "migrations" table?: ', 'y');

        // Check if the answer is true
        if (preg_match('/^y/', $ans))
        {
            // Create the migrations table
            $this->call('migrate:install');

            // Run the Migrations
            $this->call('migrate');
            
            // Run database seeding
            $this->seedDB();
        }
    }
    protected function seedDB()
    {
        // Ask the user whether to run the resr
        $ans = $this->ask('Seed your database?: ', 'y');

        // Check if the answer is true
        if (preg_match('/^y/', $ans))
        {
            $this->call('db:seed');
            $this->comment('');
            $this->comment('Database successfully seeded.');
            $this->comment('=====================================');
            echo "Your app is now ready!";
        }
    }

}
