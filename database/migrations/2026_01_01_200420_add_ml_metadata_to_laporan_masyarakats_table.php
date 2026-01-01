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
        Schema::table('laporan_masyarakats', function (Blueprint $table) {
            $table->decimal('ml_confidence', 5, 2)->nullable()->after('status')->comment('ML prediction confidence score (0-1)');
            $table->string('ml_label', 20)->nullable()->after('ml_confidence')->comment('ML prediction label (spam/valid)');
            $table->text('ml_reason')->nullable()->after('ml_label')->comment('ML detection reason');
            $table->decimal('ml_processing_time', 8, 3)->nullable()->after('ml_reason')->comment('ML processing time in seconds');
            $table->timestamp('ml_checked_at')->nullable()->after('ml_processing_time')->comment('When ML validation was performed');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('laporan_masyarakats', function (Blueprint $table) {
            $table->dropColumn(['ml_confidence', 'ml_label', 'ml_reason', 'ml_processing_time', 'ml_checked_at']);
        });
    }
};
