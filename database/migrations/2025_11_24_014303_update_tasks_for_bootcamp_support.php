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
        Schema::table('tasks', function (Blueprint $table) {
            // Add bootcamp support fields if not exists
            if (!Schema::hasColumn('tasks', 'bootcamp_id')) {
                $table->unsignedBigInteger('bootcamp_id')->nullable()->after('class_id');
                $table->foreign('bootcamp_id')->references('id')->on('bootcamps')->onDelete('cascade');
            }
            
            // Make class_id nullable to support bootcamp-only tasks
            $table->unsignedBigInteger('class_id')->nullable()->change();
            
            // Add task order for bootcamp progression
            $table->integer('task_order')->default(1)->after('instructions');
            
            // Add minimum score requirement
            $table->integer('min_score')->default(70)->after('task_order'); // Minimum score to pass
            
            // Add task type
            $table->enum('task_type', ['assignment', 'project', 'quiz', 'final_project'])->default('assignment')->after('min_score');
            
            // Add weight for final score calculation
            $table->decimal('weight', 5, 2)->default(1.00)->after('task_type'); // Weight in final score
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn(['task_order', 'min_score', 'task_type', 'weight']);
            
            if (Schema::hasColumn('tasks', 'bootcamp_id')) {
                $table->dropForeign(['bootcamp_id']);
                $table->dropColumn('bootcamp_id');
            }
            
            $table->unsignedBigInteger('class_id')->nullable(false)->change();
        });
    }
};