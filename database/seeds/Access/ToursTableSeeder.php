<?php

use Illuminate\Database\Seeder;

class ToursTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {

		DB::table('tours')->delete();

		DB::table('tours')->insert([
			['title' => 'First tour', 'description' => 'Some good trip', 'user_id' => 1, 'rate' => 10, 'accommodates' => 1, 'rules' => 'no smoking'],
			['title' => 'Mara tour', 'description' => 'You will enjoy', 'user_id' => 2, 'rate' => 10, 'accommodates' => 2, 'rules' => 'no drinking'],
			['title' => 'Gedi ruins', 'description' => 'Come join', 'user_id' => 1, 'rate' => 13, 'accommodates' => 3, 'rules' => 'no lateness'],
			['title' => 'Magadi tour', 'description' => 'A lot of swimming', 'user_id' => 2, 'rate' => 15, 'accommodates' => 4, 'rules' => 'no outside food'],
		]);
	}
}
