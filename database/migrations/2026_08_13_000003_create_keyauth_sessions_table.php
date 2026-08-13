<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('keyauth_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('keyauth_id')->constrained('keyauth')->cascadeOnDelete();
            $table->string('session_id')->unique();
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->string('device_type')->nullable();
            $table->timestamp('last_activity');
            $table->timestamp('expires_at')->nullable();
            $table->boolean('is_current')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('keyauth_sessions');
    }
};
