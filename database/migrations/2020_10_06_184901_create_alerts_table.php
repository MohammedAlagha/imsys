<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlertsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alerts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pump_id')->constrained('pumps');
            $table->enum('severity', ['danger', 'warning', 'info']);
            $table->enum('type', ['state', 'temp_main_bearing', 'temp_stator', 'ohm_leak_stator', 'leak_junction']);
            $table->enum('status', ['open', 'closed']);
            $table->string('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('alerts_users', function (Blueprint $table) {
            $table->foreignId('alert_id')->constrained('alerts');
            $table->foreignId('user_id')->constrained('users');
            $table->timestamps();
            $table->primary(['alert_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('alerts_users');
        Schema::dropIfExists('alerts');
    }
}
