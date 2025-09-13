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
        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->unsignedBigInteger('tutor_id');
            $table->integer('capacity')->default(20);
            $table->integer('enrolled')->default(0);
            $table->decimal('price', 10, 2);
            $table->datetime('start_date');
            $table->datetime('end_date');
            $table->string('schedule')->nullable(); // e.g., 'Mon,Wed,Fri 10:00-12:00'
            $table->enum('status', ['active', 'inactive', 'completed'])->default('active');
            $table->string('category')->nullable();
            $table->timestamps();
            
            $table->foreign('tutor_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classes');
    }
};
