<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DBCreate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creating the database.';

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
        $this->comment('');
        $this->comment('=====================================');
        $this->comment('');

        // Fetch the defined database name
        $db_type = \Config::get('database.default');
        $connection = \Config::get('database.connections.'.$db_type);
        $host = $connection['host'];
        $username = $connection['username'];
        $password = $connection['password'];
        $database = $connection['database'];

        // Get db name
        $db = $this->ask('What is the name of the database you want to create?', $database);
        $this->comment('');
        $this->comment('-------------------------------------');
        $this->comment('');

        // Try to create it
        try 
        {
            // Create connection
            $conn = new \mysqli($host, $username, $password);

            $this->info(json_encode($conn));
            // return $conn;

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            } 

            // Create database
            $sql = "CREATE DATABASE `$db`";
            if ($conn->query($sql) === TRUE) {
                echo "Sucessfully created database $db!";
            } else {
                echo "Error creating database: " . $conn->error;
            }
            $conn->close();
            
        }
        catch(Exception $e){
            $this->info('There was a problem creating database "'.$db.'"');
            $this->info(json_encode($e));
            die;
        }
    }
}
