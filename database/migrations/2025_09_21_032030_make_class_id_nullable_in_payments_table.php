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
        Schema::table('payments', function (Blueprint $table) {
            // Drop the foreign key constraint first
            $table->dropForeign(['class_id']);
            
            // Modify the column to be nullable
            $table->unsignedBigInteger('class_id')->nullable()->change();
            
            // Add the foreign key constraint back with nullable
            $table->foreign('class_id')->references('id')->on('classes')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            // Drop the foreign key constraint
            $table->dropForeign(['class_id']);
            
            // Modify the column to be not nullable
            $table->unsignedBigInteger('class_id')->nullable(false)->change();
            
            // Add the foreign key constraint back
            $table->foreign('class_id')->references('id')->on('classes')->onDelete('cascade');
        });
    }
};