<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->increments('user_id');
            $table->string('login', 255)->unique();
            $table->string('email', 255)->unique();
            $table->string('twitch_channel', 255)->default(null);
            $table->string('description', 255);
            $table->integer('level', false, true)->default(1);
            $table->dateTime('last_seen_watching')->default(null);
            $table->string('experience_token', 100)->default(null);
            $table->integer('experience', false, true);
            $table->string('password', 60);
            $table->tinyInteger('streaming')->default(0);
            $table->rememberToken();
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
        Schema::drop('user');
    }

}
