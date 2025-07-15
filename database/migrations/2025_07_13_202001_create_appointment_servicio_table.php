<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentServicioTable extends Migration
{
    public function up()
    {
        Schema::create('appointment_service', function (Blueprint $table) {
            $table->uuid('appointment_id');
            $table->uuid('service_id');
            $table->integer('quantity')->default(1);
            $table->text('special_requests')->nullable();
            $table->timestamps();

            $table->primary(['appointment_id', 'service_id']);
            $table->foreign('appointment_id')->references('id')->on('appointments')->onDelete('cascade');
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('appointment_service');
    }
}
