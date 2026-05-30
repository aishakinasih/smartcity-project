<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('laporans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade'); 
            $table->string('instansi'); 
            $table->string('judul');
            $table->text('isi_laporan');
            $table->string('lokasi');
            $table->string('foto')->nullable(); 
            $table->enum('urgensi', ['Tinggi', 'Sedang', 'Rendah'])->default('Rendah');
            $table->float('confidence_score')->default(0.0);
            $table->enum('status', ['Masuk', 'Diproses', 'Selesai'])->default('Masuk');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporans');
    }
};