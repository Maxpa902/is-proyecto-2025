<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inscripciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_cliente')->constrained('usuarios')->onDelete('cascade');
            $table->foreignId('id_sesion')->constrained('sesiones')->onDelete('cascade');
            $table->dateTime('fecha_hora_inscripcion');
            $table->enum('estado', ['confirmada', 'cancelada', 'asistio', 'no_asistio'])->default('confirmada');
            $table->timestamps();

            $table->unique(['id_cliente', 'id_sesion'], 'inscripciones_natural_key');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inscripciones');
    }
};
