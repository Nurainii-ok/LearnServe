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
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('task_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('class_id')->nullable()->constrained('classes')->onDelete('cascade');
            $table->foreignId('bootcamp_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('certificate_number')->unique();
            $table->string('type')->default('task'); // task, class, bootcamp
            $table->string('title');
            $table->text('description')->nullable();
            $table->decimal('final_score', 5, 2)->nullable();
            $table->date('completion_date');
            $table->foreignId('issued_by')->constrained('users')->onDelete('cascade');
            $table->string('status')->default('active'); // active, revoked
            $table->json('metadata')->nullable(); // Additional data
            $table->timestamps();
            
            $table->index(['user_id', 'type']);
            $table->index(['certificate_number']);
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
