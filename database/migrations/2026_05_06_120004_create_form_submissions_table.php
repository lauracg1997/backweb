<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('form_submissions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('surname')->nullable();
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('company')->nullable();
            $table->string('cargo')->nullable();
            $table->string('employees')->nullable();
            $table->text('message')->nullable();
            $table->enum('source', ['web', 'resource'])->default('web');
            $table->string('resource_name')->nullable();
            $table->enum('status', ['Pendiente', 'Contactado', 'Llamada realizada', 'Conversación mantenida'])->default('Pendiente');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('form_submissions');
    }
};
