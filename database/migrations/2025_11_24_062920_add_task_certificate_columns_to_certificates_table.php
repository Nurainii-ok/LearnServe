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
        Schema::table('certificates', function (Blueprint $table) {
            $table->unsignedBigInteger('task_id')->nullable()->after('bootcamp_id');
            $table->unsignedBigInteger('class_id')->nullable()->after('task_id');
            $table->string('type')->default('bootcamp')->after('certificate_code'); // task, class, bootcamp
            $table->string('title')->nullable()->after('type');
            $table->text('description')->nullable()->after('title');
            $table->unsignedBigInteger('issued_by')->nullable()->after('status');
            
            // Add foreign key constraints
            $table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade');
            $table->foreign('class_id')->references('id')->on('classes')->onDelete('cascade');
            $table->foreign('issued_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('certificates', function (Blueprint $table) {
            $table->dropForeign(['task_id']);
            $table->dropForeign(['class_id']);
            $table->dropForeign(['issued_by']);
            $table->dropColumn(['task_id', 'class_id', 'type', 'title', 'description', 'issued_by']);
        });
    }
};
