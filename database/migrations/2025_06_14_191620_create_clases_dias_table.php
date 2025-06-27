<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clase_dias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_clase')->constrained('clases')->onDelete('cascade');
            $table->foreignId('id_dia_semana')->constrained('dias_semana')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['id_clase', 'id_dia_semana'], 'clase_dias_natural_key');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clase_dias');
    }
};
