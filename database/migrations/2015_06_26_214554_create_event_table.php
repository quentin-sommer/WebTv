<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEventTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event', function (Blueprint $table) {
            $table->increments('event_id');
            $table->string('title', 255);
            $table->dateTime('start');
            $table->dateTime('end');
            $table->string('timezone');
            $table->string('color', 20);
            $table->boolean('allDay')->default(null);
            $table->string('repetitions')->default(null);
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
        Schema::drop('event');
    }

}
