<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            // Hapus kolom email & unique index
            if (Schema::hasColumn('users', 'email')) {
                $table->dropUnique('users_email_unique');
                $table->dropColumn('email');
            }

            // Hapus kolom bawaan Jetstream yang tidak kamu pakai
            if (Schema::hasColumn('users', 'email_verified_at')) {
                $table->dropColumn('email_verified_at');
            }
            if (Schema::hasColumn('users', 'current_team_id')) {
                $table->dropColumn('current_team_id');
            }
            if (Schema::hasColumn('users', 'profile_photo_path')) {
                $table->dropColumn('profile_photo_path');
            }

            // Tambah kolom username
            if (!Schema::hasColumn('users', 'username')) {
                $table->string('username')->unique()->after('name');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            // Balikkan perubahan (opsional)
            if (Schema::hasColumn('users', 'username')) {
                $table->dropUnique('users_username_unique');
                $table->dropColumn('username');
            }

            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('profile_photo_path')->nullable();
            $table->foreignId('current_team_id')->nullable();
        });
    }
};
