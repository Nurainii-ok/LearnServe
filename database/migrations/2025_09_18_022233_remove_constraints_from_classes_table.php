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
        Schema::table('classes', function (Blueprint $table) {
            // Remove constraints to make classes flexible
            $table->dropColumn(['capacity', 'start_date', 'end_date', 'schedule']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('classes', function (Blueprint $table) {
            // Restore the columns if needed
            $table->integer('capacity')->default(20);
            $table->datetime('start_date')->nullable();
            $table->datetime('end_date')->nullable();
            $table->string('schedule')->nullable();
        });
    }
};
