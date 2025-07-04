<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dias_semana', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 20);
            $table->tinyInteger('orden');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dias_semana');
    }
};
