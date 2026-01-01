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
        Schema::create('feedback', function (Blueprint $table) {
             $table->id();
             $table->foreignId('laporan_id')->constrained('laporan_masyarakats')->cascadeOnDelete();
             $table->foreignId('admin_id')->constrained('users')->cascadeOnDelete();
             $table->text('catatan');
             $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedback');
    }
};
