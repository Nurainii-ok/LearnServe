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
        Schema::create('bootcamp_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('bootcamp_id');
            $table->enum('status', ['active', 'completed', 'dropped', 'suspended'])->default('active');
            $table->date('enrolled_date');
            $table->date('completion_date')->nullable();
            $table->decimal('progress_percentage', 5, 2)->default(0.00); // 0-100%
            $table->integer('completed_tasks')->default(0);
            $table->integer('total_tasks')->default(0);
            $table->decimal('average_score', 5, 2)->nullable();
            $table->json('task_scores')->nullable(); // Array of task scores
            $table->boolean('certificate_eligible')->default(false);
            $table->boolean('certificate_issued')->default(false);
            $table->text('notes')->nullable();
            $table->timestamps();
            
            // Indexes
            $table->index(['user_id', 'bootcamp_id']);
            $table->index('status');
            $table->index('certificate_eligible');
            
            // Foreign keys
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('bootcamp_id')->references('id')->on('bootcamps')->onDelete('cascade');
            
            // Unique constraint - one enrollment per user per bootcamp
            $table->unique(['user_id', 'bootcamp_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bootcamp_users');
    }
};