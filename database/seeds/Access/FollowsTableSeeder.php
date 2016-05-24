<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Follow;

class FollowsTableSeeder extends Seeder 
{

	public function run()
	{
		// $faker = Faker::create();

		foreach(range(1, 5) as $index)
		{
			Follow::create([
				'author_id' => $index,
				'user_id' => rand(1,5),
				'category_id' => rand(1,10)
			]);
		}
	}

}