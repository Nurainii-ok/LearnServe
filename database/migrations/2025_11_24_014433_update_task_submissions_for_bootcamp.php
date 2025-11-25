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
        Schema::table('task_submissions', function (Blueprint $table) {
            // Add detailed status for bootcamp workflow
            $table->enum('submission_status', [
                'pending',      // Waiting for review
                'under_review', // Being reviewed by mentor
                'passed',       // Passed - meets requirements
                'revision',     // Needs revision
                'failed'        // Failed - doesn't meet minimum requirements
            ])->default('pending')->after('graded_by');
            
            // Add revision tracking
            $table->integer('revision_count')->default(0)->after('submission_status');
            $table->text('mentor_feedback')->nullable()->after('revision_count');
            $table->timestamp('reviewed_at')->nullable()->after('mentor_feedback');
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->onDelete('set null')->after('reviewed_at');
            
            // Add submission URL support (for links like GitHub, Figma, etc.)
            $table->text('submission_url')->nullable()->after('reviewed_by');
            $table->text('submission_notes')->nullable()->after('submission_url'); // Student notes
            
            // Add score validation
            $table->boolean('meets_minimum_score')->default(false)->after('submission_notes');
            
            // Add resubmission tracking
            $table->timestamp('resubmitted_at')->nullable()->after('meets_minimum_score');
            $table->json('revision_history')->nullable()->after('resubmitted_at'); // Track all revisions
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('task_submissions', function (Blueprint $table) {
            $table->dropForeign(['reviewed_by']);
            $table->dropColumn([
                'submission_status',
                'revision_count', 
                'mentor_feedback',
                'reviewed_at',
                'reviewed_by',
                'submission_url',
                'submission_notes',
                'meets_minimum_score',
                'resubmitted_at',
                'revision_history'
            ]);
        });
    }
};