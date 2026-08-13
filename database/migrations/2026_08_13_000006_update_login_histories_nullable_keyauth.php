<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('ALTER TABLE `login_histories` MODIFY `keyauth_id` BIGINT UNSIGNED NULL');
        Schema::table('login_histories', function (Blueprint $table) {
            $table->dropForeign(['keyauth_id']);
            $table->foreign('keyauth_id')->references('id')->on('keyauth')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('login_histories', function (Blueprint $table) {
            $table->dropForeign(['keyauth_id']);
        });
        DB::statement('ALTER TABLE `login_histories` MODIFY `keyauth_id` BIGINT UNSIGNED NOT NULL');
        Schema::table('login_histories', function (Blueprint $table) {
            $table->foreign('keyauth_id')->references('id')->on('keyauth')->cascadeOnDelete();
        });
    }
};
