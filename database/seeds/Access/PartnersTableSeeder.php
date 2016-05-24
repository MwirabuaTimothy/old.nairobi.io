<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class PartnersTableSeeder extends Seeder 
{
	
	public function run()
	{
		$faker = Faker::create();

		$partners = array();
		for ($i=1; $i < 6; $i++) { 
			array_push($partners, array(
				'name' => $faker->company,
				'logo' => '/assets/img/partners/logo'. $i.'.png',
				'link' => $faker->url,
				'public' => rand(0, 1),
            ));
		};

		// Uncomment the below to run the seeder
		DB::table('partners')->insert($partners);
	}

}
