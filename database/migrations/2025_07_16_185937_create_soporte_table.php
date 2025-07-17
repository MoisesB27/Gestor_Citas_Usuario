<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSoporteTable extends Migration
{
    public function up()
    {
        Schema::create('soporte', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_completo');
            $table->string('correo_electronico');
            $table->string('asunto');
            $table->text('descripcion');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('soporte');
    }
}
