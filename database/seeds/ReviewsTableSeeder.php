<?php

use Illuminate\Database\Seeder;

class ReviewsTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		DB::table('reviews')->delete();

		DB::table('reviews')->insert([
			['tour_id' => 1, 'user_id' => 1, 'stars' => 2, 'description' => 'I loved the tour, the guide was very polite', 'parent_id' => 1],
			['tour_id' => 2, 'user_id' => 2, 'stars' => 3, 'description' => 'I loved the tour, the guide was very polite', 'parent_id' => 1],
			['tour_id' => 3, 'user_id' => 1, 'stars' => 4, 'description' => 'I loved the tour, the guide was very polite', 'parent_id' => 1],
			['tour_id' => 4, 'user_id' => 2, 'stars' => 5, 'description' => 'I loved the tour, the guide was very polite', 'parent_id' => 1],
			['tour_id' => 1, 'user_id' => 1, 'stars' => 2, 'description' => 'I loved the tour, the guide was very polite', 'parent_id' => 1],
			['tour_id' => 2, 'user_id' => 2, 'stars' => 5, 'description' => 'I loved the tour, the guide was very polite', 'parent_id' => 1],
			['tour_id' => 3, 'user_id' => 1, 'stars' => 3, 'description' => 'I loved the tour, the guide was very polite', 'parent_id' => 1],
			['tour_id' => 4, 'user_id' => 2, 'stars' => 1, 'description' => 'I loved the tour, the guide was very polite', 'parent_id' => 1],
		]);
	}
}
