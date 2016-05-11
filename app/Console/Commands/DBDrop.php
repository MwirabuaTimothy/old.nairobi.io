<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DBDrop extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:drop';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Drop a database.';

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
        // Fetch the defined database name
        $db_type = \Config::get('database.default');
        $connection = \Config::get('database.connections.'.$db_type);
        $host = $connection['host'];
        $username = $connection['username'];
        $password = $connection['password'];
        $database = $connection['database'];
        
        $this->comment('');
        $this->comment('=====================================');
        $this->comment('');
        $this->info('Current DataBase: '.$database);
        $this->comment('');
        $this->comment('-------------------------------------');
        $this->comment('');


        $this->dropDB($host, $username, $password, $database);
    }

    protected function dropDB($host, $username, $password, $database)
    {
        

        // Get db name
        $db = $this->ask('Which database do you want to delete?', $database);


        // Ask the user whether to run the rest
        $ans = $this->ask('Are you sure you want to clear DataBase '.$db.'?', 'y');

        // Check if the answer is true
        if (preg_match('/^y/', $ans))
        {

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

                // Drop database
                $sql = "DROP DATABASE `$db`";
                if ($conn->query($sql) === TRUE) {
                    echo "Sucessfully dropped database $db!";
                } else {
                    echo "Error dropping database: " . $conn->error;
                }
                $conn->close();

            }
            catch(Exception $e){
                $this->info('');
                echo "Error dropping database: $db";
                $this->info('');
                echo json_encode($e->getMessage());
                $this->info('');
                $this->info('You can try the mysql shell.');
            }

        }
        else{
            die;
        }
    }
}
