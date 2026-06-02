<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Menambahkan role dengan default 'user'
            $table->string('role')->default('user')->after('password');
            // Menambahkan nama instansi (nullable karena user biasa tidak punya instansi)
            $table->string('instansi')->nullable()->after('role');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Menghapus kembali kolom jika migrasi di-rollback
            $table->dropColumn(['role', 'instansi']);
        });
    }
};