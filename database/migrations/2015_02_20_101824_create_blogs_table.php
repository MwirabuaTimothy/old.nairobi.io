<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBlogsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('title');
            $table->string('slug')->nullable();
            $table->text('body');
            $table->text('notes');
            $table->string('category_id');
            $table->boolean('highlighted');
            $table->boolean('top_story');
            $table->boolean('public');
            $table->integer('views');
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
        Schema::drop('blogs');
    }
}
