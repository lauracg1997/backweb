<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('resources', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('category', ['Demo', 'Webinar', 'Guía', 'Plantilla']);
            $table->text('description')->nullable();
            $table->string('type')->nullable();
            $table->string('size')->nullable();
            $table->string('url')->nullable();
            $table->enum('status', ['active', 'disabled'])->default('active');
            $table->unsignedInteger('downloads')->default(0);
            $table->timestamp('webinar_date')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resources');
    }
};
