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
            $table->string('login', 30)->unique();
            $table->string('pseudo', 30)->unique();
            $table->string('email', 255)->unique();
            $table->string('twitch_channel', 255)->default(null);
            $table->text('description');
            $table->string('avatar', 255)->default('default.jpg');
            $table->string('stream_banner', 255)->default('default.jpg');
            $table->string('stream_preview', 255)->default(null);
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
