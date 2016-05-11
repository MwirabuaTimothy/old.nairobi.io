<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateToursTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('tours', function (Blueprint $table) {
			$table->increments('id');
			$table->string('title');
			$table->string('description');
			$table->integer('user_id');
			$table->string('image');
			$table->timestamp('available_from');
			$table->timestamp('available_to');
			$table->string('rate');
			$table->string('accommodates');
			$table->string('rules');
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
		Schema::drop('tours');
	}
}
