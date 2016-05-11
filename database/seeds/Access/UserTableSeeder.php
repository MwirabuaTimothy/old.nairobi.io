<?php

use Carbon\Carbon as Carbon;
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
				'email' => 'techytimo@gmail.com',
				'password' => bcrypt('tim'),
				'confirmation_code' => md5(uniqid(mt_rand(), true)),
				'confirmed' => true,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
				'gender' => 'm',
				'fb_uid' => 'null',
				'zip' => '+254',
				'phone' => '711451409',
				'image' => 'null',
				'dob' => '1991-01-09',
				'about' => 'some random stuff',
				'education_institution' => 'JKUAT',
				'education_course' => 'Some course',
			],
			[
				'first_name' => 'Default',
				'last_name' => 'User',
				'email' => 'user@user.com',
				'password' => bcrypt('1234'),
				'confirmation_code' => md5(uniqid(mt_rand(), true)),
				'confirmed' => true,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
				'gender' => 'm',
				'fb_uid' => 'null',
				'zip' => '+254',
				'phone' => '703123456',
				'image' => 'null',
				'dob' => '1991-01-09',
				'about' => 'some random stuff',
				'education_institution' => 'JKUAT',
				'education_course' => 'Some course',
			],
		];

		DB::table(config('access.users_table'))->insert($users);

		if (env('DB_CONNECTION') == 'mysql') {
			DB::statement('SET FOREIGN_KEY_CHECKS=1;');
		}
	}
}