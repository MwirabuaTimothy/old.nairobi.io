<?php

use Illuminate\Database\Seeder;

class MessagesTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		DB::table('messages')->delete();

		DB::table('messages')->insert([
			['booking_id' => 1, 'user_id' => 1, 'content' => 'some message'],
			['booking_id' => 2, 'user_id' => 2, 'content' => 'some message'],
			['booking_id' => 3, 'user_id' => 2, 'content' => 'some message'],
			['booking_id' => 4, 'user_id' => 1, 'content' => 'some message'],
			['booking_id' => 1, 'user_id' => 2, 'content' => 'some message'],
			['booking_id' => 2, 'user_id' => 1, 'content' => 'some message'],
			['booking_id' => 3, 'user_id' => 2, 'content' => 'some message'],
			['booking_id' => 4, 'user_id' => 1, 'content' => 'some message'],
		]);
	}
}
