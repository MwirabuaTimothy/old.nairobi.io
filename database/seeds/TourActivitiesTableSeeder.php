<?php

use Illuminate\Database\Seeder;

class TourActivitiesTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		DB::table('tour_activities')->delete();

		DB::table('tour_activities')->insert([
			['tour_id' => 1, 'activity_id' => 1],
			['tour_id' => 2, 'activity_id' => 2],
			['tour_id' => 3, 'activity_id' => 4],
			['tour_id' => 4, 'activity_id' => 3],
			['tour_id' => 1, 'activity_id' => 5],
			['tour_id' => 2, 'activity_id' => 6],
			['tour_id' => 3, 'activity_id' => 7],
			['tour_id' => 4, 'activity_id' => 1],
		]);
	}
}
