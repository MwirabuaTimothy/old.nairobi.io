<?php

use Illuminate\Database\Seeder;

class ActivityTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		DB::table('activities')->delete();

		DB::table('activities')->insert([
			['name' => 'Site seeing'],
			['name' => 'Swimming'],
			['name' => 'Hiking'],
			['name' => 'Mountain climbing'],
			['name' => 'Walking'],
			['name' => 'Bird watching'],
			['name' => 'Surfing'],
			['name' => 'Cycling'],
		]);
	}
}
