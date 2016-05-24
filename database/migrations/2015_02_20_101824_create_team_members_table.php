<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTeamMembersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('team_members', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('image');
			$table->string('title');
			$table->string('description');
			$table->string('linkedin');
			$table->string('twitter');
			$table->string('facebook');
			$table->boolean('public');
			$table->datetime('deleted_at');
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('team_members');
	}

}
