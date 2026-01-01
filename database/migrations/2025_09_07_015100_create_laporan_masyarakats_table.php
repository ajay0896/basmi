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
        Schema::create('laporan_masyarakats', function (Blueprint $table) {
             $table->id();
             $table->string('kode_laporan')->unique();
             $table->foreignId('user_id')->constrained()->cascadeOnDelete();
             $table->foreignId('aduan_id')->constrained('aduans')->onDelete('cascade');
             $table->text('deskripsi_kejadian');
             $table->string('lokasi_kejadian');
             $table->decimal('lat', 10, 7)->nullable();
             $table->decimal('lng', 10, 7)->nullable();
             $table->foreignId('kecamatan_id')
              ->nullable()
              ->constrained('kecamatans')
              ->cascadeOnDelete();
             $table->date('tanggal_kejadian')->nullable();
             $table->string('foto')->nullable();
             $table->enum('status', ['menunggu', 'diproses', 'selesai'])->default('menunggu');
             $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_masyarakats');
    }
};
