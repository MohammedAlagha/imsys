<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePumpDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pump_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pump_id');
            $table->enum('state', [1, 0]);
            $table->unsignedBigInteger('total_start');
            $table->unsignedBigInteger('total_running_time');
            $table->double('temp_main_bearing');
            $table->double('temp_stator');
            $table->double('ohm_leak_stator');
            $table->double('leak_junction');
            $table->unsignedBigInteger('temp_main_bearing_alarm');
            $table->unsignedBigInteger('temp_stator_alarm');
            $table->unsignedBigInteger('ohm_leak_stator_alarm');
            $table->unsignedBigInteger('leak_junction_alarm');
            $table->timestamp('data_time');
            $table->timestamps();

            $table->foreign('pump_id')->references('id')->on('pumps')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pump_data');
    }
}
