<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->string('eventImage')->nullable()->default('event.jpg');
            $table->string('eventType');
            $table->string('eventName');
            $table->string('eventPlace');
            $table->string('eventStartDate');
            $table->string('eventStartTime');
            $table->string('eventEndDate');
            $table->string('eventEndTime');
            $table->longText('eventDescription');
            $table->integer('createdBy')->nullable();
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
        Schema::dropIfExists('events');
    }
}
