<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_actividad')->constrained('actividades')->onDelete('cascade');
            $table->integer('numero_clase');
            $table->time('hora_inicio');
            $table->time('hora_fin');
            $table->integer('capacidad_maxima');
            $table->enum('estado', ['activa', 'inactiva'])->default('activa');
            $table->string('nombre_completo_profesor', 150);
            $table->string('lugar', 100);
            $table->timestamps();

            $table->unique(['id_actividad', 'numero_clase'], 'clases_natural_key');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clases');
    }
};
