<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApiLoginsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('api_logins', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('api_token');
            $table->string('gcm');
            $table->string('device');
            $table->string('platform');
            $table->string('version');
            $table->string('ip_address');
            $table->string('fb_code');
            $table->string('gg_code');
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
    public function down()
    {
        Schema::drop('api_logins');
    }
}
