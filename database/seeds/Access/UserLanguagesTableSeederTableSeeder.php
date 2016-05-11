<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class UserLanguagesTableSeeder extends Seeder
{
    public function run()
    {
        // TestDummy::times(20)->create('App\Post');
        DB::table('user_languages')->delete();

		DB::table('user_languages')->insert([
			['user_id' => 1, 'language_id' => 1],
			['user_id' => 1, 'language_id' => 2],
			['user_id' => 1, 'language_id' => 3],
			['user_id' => 2, 'language_id' => 4],
			['user_id' => 2, 'language_id' => 5],
			['user_id' => 2, 'language_id' => 6],
		]);
    }
}
