<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sesiones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_clase')->constrained('clases')->onDelete('cascade');
            $table->integer('numero_sesion');
            $table->date('fecha');
            $table->timestamps();

            $table->unique(['id_clase', 'numero_sesion'], 'sesiones_natural_key');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sesiones');
    }
};
