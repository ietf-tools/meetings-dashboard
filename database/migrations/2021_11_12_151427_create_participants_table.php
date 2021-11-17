<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParticipantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('participants', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('email');
            $table->string('ipv4Address')->nullable();
            $table->string('geo')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('geoCode')->nullable();
            $table->dateTime('lastGeoUpdate')->nullable();
            $table->dateTime('login')->nullable();
            $table->dateTime('logout')->nullable();
            $table->decimal('status', 2,0)->default(0);
            $table->decimal('hide', 2,0)->default(0);
            $table->decimal('dataTrackerID', 32,0)->nullable();
            $table->string('uniHash')->unique();
            $table->decimal('meetingID', 5,0);
            $table->decimal('sessionCount', 5,0)->nullable();
            $table->decimal('hackathonOnly', 2,0)->nullable();
            $table->decimal('hacakathonParticipant', 2,0)->nullable();
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
        //Schema::dropIfExists('participants');
    }
}
