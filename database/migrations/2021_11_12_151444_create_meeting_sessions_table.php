<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeetingSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meeting_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('parent')->nullable();
            $table->string('sessionChair')->nullable();
            $table->string('sessionChairEmail')->nullable();
            $table->date('startDate')->nullable();
            $table->date('endDate')->nullable();
            $table->time('startTime')->nullable();
            $table->time('endTime')->nullable();
            $table->decimal('currentParticipantCount', 8,0)->default(0)->nullable();
            $table->decimal('totalParticipantCount', 8,0)->default(0)->nullable();
            $table->mediumText('participants')->nullable();
            $table->string('description')->nullable();
            $table->decimal('meetingNumber', 8,0)->nullable();
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
        //Schema::dropIfExists('meeting_sessions');
    }
}
