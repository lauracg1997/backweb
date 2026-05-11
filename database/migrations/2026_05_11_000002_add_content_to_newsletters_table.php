<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('newsletters', function (Blueprint $table) {
            $table->string('subject')->nullable()->after('name');
            $table->text('content')->nullable()->after('subject');
            $table->string('status')->default('Borrador')->after('content');
            $table->timestamp('sent_at')->nullable()->after('last_sent_at');
        });
    }

    public function down(): void
    {
        Schema::table('newsletters', function (Blueprint $table) {
            $table->dropColumn(['subject', 'content', 'status', 'sent_at']);
        });
    }
};
