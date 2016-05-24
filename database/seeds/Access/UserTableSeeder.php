<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Class UserTableSeeder
 */
class UserTableSeeder extends Seeder {
	public function run() {
		if (env('DB_CONNECTION') == 'mysql') {
			DB::statement('SET FOREIGN_KEY_CHECKS=0;');
		}

		if (env('DB_CONNECTION') == 'mysql') {
			DB::table(config('access.users_table'))->truncate();
		} elseif (env('DB_CONNECTION') == 'sqlite') {
			DB::statement('DELETE FROM ' . config('access.users_table'));
		} else {
			//For PostgreSQL or anything else
			DB::statement('TRUNCATE TABLE ' . config('access.users_table') . ' CASCADE');
		}

		//Add the master administrator, user id of 1
		$users = [
			[
				'first_name' => 'Timothy',
				'last_name' => 'Mwirabua',
				'email' => 'tim@gmail.com',
				'password' => bcrypt('tim'),
				'confirmation_code' => md5(uniqid(mt_rand(), true)),
				'confirmed' => true,
				'zip' => '+254',
				'phone' => '711451409',
				'bio' => 'some random stuff',
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
			],
			[
				'first_name' => 'Steve',
				'last_name' => 'Kamau',
				'email' => 'steve@email.com',
				'password' => bcrypt('steve'),
				'confirmation_code' => md5(uniqid(mt_rand(), true)),
				'confirmed' => true,
				'zip' => '+254',
				'phone' => '715611306',
				'bio' => 'some random stuff',
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
			],
		];

		DB::table(config('access.users_table'))->insert($users);

		if (env('DB_CONNECTION') == 'mysql') {
			DB::statement('SET FOREIGN_KEY_CHECKS=1;');
		}
	}
}