<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeetingInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meeting_info', function (Blueprint $table) {
            $table->id();
            $table->decimal('meetingNumber', 4,0);
            $table->string('meetingCity')->nullable();
            $table->string('meetingCountry')->nullable();
            $table->string('meetingTZ')->nullable();
            $table->date('startDate')->nullable();
            $table->date('endDate')->nullable();
            $table->date('hackStartDate')->nullable();
            $table->date('hackEndDate')->nullable();
            $table->decimal('active', 1,0)->default(0)->nullable();
            $table->decimal('show', 1,0)->default(1)->nullable();
            $table->string('meetechoAPIURL')->nullable();
            $table->string('meetechoAPIToken')->nullable();
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
        //Schema::dropIfExists('meeting_info');
    }
}
