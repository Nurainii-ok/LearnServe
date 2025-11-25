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
        Schema::table('certificates', function (Blueprint $table) {
            // Add new columns for professional certificate system
            $table->string('certificate_id')->unique()->after('bootcamp_id');
            $table->string('pdf_path')->nullable()->after('certificate_id');
            $table->string('qr_code_path')->nullable()->after('pdf_path');
            $table->timestamp('issued_at')->nullable()->after('qr_code_path');
            
            // Update existing columns
            $table->string('status')->default('active')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('certificates', function (Blueprint $table) {
            $table->dropColumn(['certificate_id', 'pdf_path', 'qr_code_path', 'issued_at']);
        });
    }
};
