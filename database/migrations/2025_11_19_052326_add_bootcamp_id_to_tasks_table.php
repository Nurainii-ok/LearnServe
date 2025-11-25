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
        if (!Schema::hasColumn('tasks', 'bootcamp_id')) {
            Schema::table('tasks', function (Blueprint $table) {
                // Add bootcamp_id column
                $table->unsignedBigInteger('bootcamp_id')->nullable()->after('class_id');
            });
            
            // Add foreign key constraint in separate statement
            Schema::table('tasks', function (Blueprint $table) {
                $table->foreign('bootcamp_id')->references('id')->on('bootcamps')->onDelete('cascade');
            });
        }
        
        // Make class_id nullable in separate statement
        Schema::table('tasks', function (Blueprint $table) {
            $table->unsignedBigInteger('class_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropForeign(['bootcamp_id']);
            $table->dropColumn('bootcamp_id');
            $table->unsignedBigInteger('class_id')->nullable(false)->change();
        });
    }
};