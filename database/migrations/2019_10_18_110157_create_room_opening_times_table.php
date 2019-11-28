<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomOpeningTimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('room_opening_times', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->time('open');
            $table->time('shuts');
            $table->string('location');
            $table->unsignedInteger('day');
            $table->boolean('term_time')->default(true);
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
        Schema::dropIfExists('room_opening_times');
    }
}
