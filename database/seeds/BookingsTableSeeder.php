<?php

use Illuminate\Database\Seeder;

class BookingsTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		DB::table('bookings')->delete();

		DB::table('bookings')->insert([
			['tour_id' => 1, 'user_id' => 1, 'begin_at' => '2016-01-01 00:00:01', 'end_at' => '2016-01-01 01:00:01', 'accepted' => 1, 'tourists' => 1, 'preferences' => 'Snacks'],
			['tour_id' => 2, 'user_id' => 2, 'begin_at' => '2016-01-01 00:00:01', 'end_at' => '2016-01-01 01:00:01', 'accepted' => 1, 'tourists' => 2, 'preferences' => 'Snacks'],
			['tour_id' => 3, 'user_id' => 1, 'begin_at' => '2016-01-01 00:00:01', 'end_at' => '2016-01-01 01:00:01', 'accepted' => 1, 'tourists' => 1, 'preferences' => 'Snacks'],
			['tour_id' => 4, 'user_id' => 2, 'begin_at' => '2016-01-01 00:00:01', 'end_at' => '2016-01-01 01:00:01', 'accepted' => 1, 'tourists' => 2, 'preferences' => 'Snacks'],
			['tour_id' => 1, 'user_id' => 1, 'begin_at' => '2016-01-01 00:00:01', 'end_at' => '2016-01-01 01:00:01', 'accepted' => 1, 'tourists' => 1, 'preferences' => 'Snacks'],
			['tour_id' => 2, 'user_id' => 2, 'begin_at' => '2016-01-01 00:00:01', 'end_at' => '2016-01-01 01:00:01', 'accepted' => 1, 'tourists' => 2, 'preferences' => 'Snacks'],
			['tour_id' => 3, 'user_id' => 1, 'begin_at' => '2016-01-01 00:00:01', 'end_at' => '2016-01-01 01:00:01', 'accepted' => 1, 'tourists' => 1, 'preferences' => 'Snacks'],
			['tour_id' => 4, 'user_id' => 2, 'begin_at' => '2016-01-01 00:00:01', 'end_at' => '2016-01-01 01:00:01', 'accepted' => 1, 'tourists' => 2, 'preferences' => 'Snacks'],
		]);
	}
}
