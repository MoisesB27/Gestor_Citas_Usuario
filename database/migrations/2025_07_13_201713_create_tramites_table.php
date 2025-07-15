<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTramitesTable extends Migration
{
    public function up()
    {
        Schema::create('tramites', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->text('description')->nullable();
            $table->uuid('dependency_id');
            $table->json('mandatory_fields')->nullable();
            $table->timestamps();

            $table->foreign('dependency_id')->references('id')->on('government_dependencies')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tramites');
    }
}
