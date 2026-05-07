<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('candidates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('position');
            $table->enum('cv_type', ['Normal', 'Prácticas Curriculares', 'Prácticas Extracurriculares'])->default('Normal');
            $table->enum('status', ['Nuevo', 'En Selección', 'Entrevistado', 'Declinado'])->default('Nuevo');
            $table->string('cv_url')->nullable();
            $table->string('location')->nullable();
            $table->unsignedSmallInteger('duracion_meses')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('candidates');
    }
};
