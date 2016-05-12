<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBookingsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('bookings', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('tour_id');
			$table->integer('user_id');
			$table->timestamp('begin_at');
			$table->timestamp('end_at');
			$table->boolean('accepted');
			$table->integer('tourists');
			$table->string('preferences');
			$table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->timestamp('updated_at');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::create('bookings');
	}
}