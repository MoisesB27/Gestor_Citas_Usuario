<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentAccessLogsTable extends Migration
{
    public function up()
    {
        Schema::create('appointment_access_logs', function (Blueprint $table) {
            $table->id();
            $table->uuid('appointment_id');
            $table->timestamp('accessed_at')->useCurrent();
            $table->ipAddress('ip_address')->nullable();
            $table->timestamps();

            $table->foreign('appointment_id')->references('id')->on('appointments')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('appointment_access_logs');
    }
}
