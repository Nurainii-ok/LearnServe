<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('video_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('video_content_id')->constrained()->onDelete('cascade');
            $table->bigInteger('class_id'); 
            $table->foreign('class_id')->references('id')->on('classes')->onDelete('cascade');
            
            $table->integer('watch_time')->default(0); // in seconds
            $table->integer('total_duration')->default(0); // in seconds
            $table->decimal('progress_percentage', 5, 2)->default(0); // 0.00 to 100.00
            $table->boolean('is_completed')->default(false);
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            // Ensure one progress record per user per video
            $table->unique(['user_id', 'video_content_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('video_progress');
    }
};
