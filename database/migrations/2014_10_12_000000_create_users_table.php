<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('users', function (Blueprint $table) {
			$table->increments('id');
			$table->string('first_name');
			$table->string('last_name');
			$table->string('username');
			$table->string('email')->unique();
			$table->enum('gender', ['m, f']);
            $table->string('fb_uid');
			$table->string('gg_uid');
			$table->string('zip');
			$table->string('phone');
			$table->string('image');
			$table->date('dob');
			$table->string('bio');
			$table->string('education_institution');
			$table->string('education_course');
			$table->string('organization');
			$table->string('about');
			$table->string('hometown');
			$table->string('current_city');
			$table->string('national_id');
			$table->string('passport');
			$table->string('password')->nullable();
			$table->string('confirmation_code');
			$table->boolean('confirmed')->default(config('access.users.confirm_email') ? false : true);
            $table->boolean('phone_verified');
            $table->boolean('national_id_verified');
            $table->boolean('passport_verified');
            $table->boolean('organization_verified');
            $table->integer('verified_by');
			$table->rememberToken();
			$table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->timestamp('updated_at');
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('users');
	}
}
