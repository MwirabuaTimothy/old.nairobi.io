<?php

use Illuminate\Database\Seeder;

class BlogsTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		DB::table('blogs')->delete();

		DB::table('blogs')->insert([
		]);
	}
}
