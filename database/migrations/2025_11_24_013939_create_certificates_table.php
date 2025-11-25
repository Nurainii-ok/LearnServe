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
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('bootcamp_id');
            $table->string('certificate_number')->unique(); // Format: CERT-BOOTCAMP-001-2025
            $table->string('certificate_code')->unique(); // QR Code verification
            $table->string('student_name');
            $table->string('bootcamp_title');
            $table->string('instructor_name');
            $table->date('completion_date');
            $table->date('issue_date');
            $table->integer('total_tasks');
            $table->integer('completed_tasks');
            $table->decimal('final_score', 5, 2)->nullable(); // Average score
            $table->enum('status', ['active', 'revoked'])->default('active');
            $table->string('certificate_file')->nullable(); // PDF file path
            $table->json('metadata')->nullable(); // Additional data
            $table->timestamps();
            
            // Indexes
            $table->index(['user_id', 'bootcamp_id']);
            $table->index('certificate_number');
            $table->index('certificate_code');
            
            // Foreign keys
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('bootcamp_id')->references('id')->on('bootcamps')->onDelete('cascade');
            
            // Unique constraint - one certificate per user per bootcamp
            $table->unique(['user_id', 'bootcamp_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};