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
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('class_id')->nullable();
            $table->unsignedBigInteger('bootcamp_id')->nullable();
            $table->enum('type', ['class', 'bootcamp']);
            $table->enum('status', ['active', 'completed', 'dropped', 'pending'])->default('active');
            $table->datetime('enrolled_at');
            $table->datetime('completed_at')->nullable();
            $table->decimal('progress', 5, 2)->default(0.00); // Progress percentage (0-100)
            $table->text('notes')->nullable();
            $table->timestamps();
            
            // Foreign key constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('class_id')->references('id')->on('classes')->onDelete('cascade');
            $table->foreign('bootcamp_id')->references('id')->on('bootcamps')->onDelete('cascade');
            
            // Indexes
            $table->index(['user_id', 'type']);
            $table->index(['class_id']);
            $table->index(['bootcamp_id']);
            
            // Unique constraint to prevent duplicate enrollments
            $table->unique(['user_id', 'class_id', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};
