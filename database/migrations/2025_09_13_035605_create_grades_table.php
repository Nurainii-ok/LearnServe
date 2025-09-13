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
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('class_id');
            $table->unsignedBigInteger('task_id')->nullable();
            $table->unsignedBigInteger('graded_by');
            $table->decimal('score', 5, 2); // Score out of 100
            $table->string('grade')->nullable(); // A, B, C, D, F
            $table->text('feedback')->nullable();
            $table->enum('type', ['assignment', 'quiz', 'exam', 'project', 'participation'])->default('assignment');
            $table->timestamps();
            
            $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('class_id')->references('id')->on('classes')->onDelete('cascade');
            $table->foreign('task_id')->references('id')->on('tasks')->onDelete('set null');
            $table->foreign('graded_by')->references('id')->on('users')->onDelete('cascade');
            
            $table->index(['student_id', 'class_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};
