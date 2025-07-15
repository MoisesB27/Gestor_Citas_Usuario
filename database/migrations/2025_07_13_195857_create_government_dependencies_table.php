<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGovernmentDependenciesTable extends Migration
{
    public function up()
    {
        Schema::create('government_dependencies', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->json('business_hours')->nullable();
            $table->integer('appointment_limit')->default(0);
            $table->integer('appointment_limit_per_user')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('government_dependencies');
    }
}
