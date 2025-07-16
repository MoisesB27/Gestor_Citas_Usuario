<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('user_profiles', function (Blueprint $table) {
            $table->string('cedula')->unique()->nullable();
            $table->enum('sexo', ['masculino', 'femenino', 'otro'])->nullable();
            $table->text('direccion')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_profiles', function (Blueprint $table) {
             $table->dropColumn(['cedula', 'sexo', 'direccion']);
        });
    }
};
