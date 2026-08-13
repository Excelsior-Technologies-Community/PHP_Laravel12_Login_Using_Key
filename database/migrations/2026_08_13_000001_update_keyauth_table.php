<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('keyauth', function (Blueprint $table) {
            $table->string('password')->nullable()->after('login_key');
            $table->timestamp('email_verified_at')->nullable()->after('password');
            $table->rememberToken()->nullable()->after('email_verified_at');
            $table->string('profile_pic')->nullable()->after('remember_token');
            $table->text('two_factor_secret')->nullable()->after('profile_pic');
            $table->text('two_factor_recovery_codes')->nullable()->after('two_factor_secret');
            $table->timestamp('two_factor_confirmed_at')->nullable()->after('two_factor_recovery_codes');
            $table->softDeletes()->after('two_factor_confirmed_at');
        });
    }

    public function down(): void
    {
        Schema::table('keyauth', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropColumn([
                'two_factor_confirmed_at',
                'two_factor_recovery_codes',
                'two_factor_secret',
                'profile_pic',
                'remember_token',
                'email_verified_at',
                'password',
            ]);
        });
    }
};
