<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Classes;

class FixClassesGaps extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:classes-gaps';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix gaps in classes IDs to make them sequential';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔧 Fixing Classes ID gaps...');
        
        // Disable foreign key checks
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Get all classes ordered by ID
        $classes = Classes::orderBy('id')->get();
        
        $this->info("Found {$classes->count()} classes");
        
        // Create ID mapping
        $idMapping = [];
        $newId = 1;
        
        foreach ($classes as $class) {
            if ($class->id != $newId) {
                $idMapping[$class->id] = $newId;
                $this->info("Will change ID {$class->id} -> {$newId}: {$class->title}");
            }
            $newId++;
        }
        
        // Update related tables first
        foreach ($idMapping as $oldId => $newId) {
            // Update payments
            \DB::table('payments')->where('class_id', $oldId)->update(['class_id' => $newId + 30000]);
            
            // Update enrollments
            \DB::table('enrollments')->where('class_id', $oldId)->update(['class_id' => $newId + 30000]);
            
            // Update video_contents
            \DB::table('video_contents')->where('class_id', $oldId)->update(['class_id' => $newId + 30000]);
            
            // Update tasks
            \DB::table('tasks')->where('class_id', $oldId)->update(['class_id' => $newId + 30000]);
            
            // Update grades
            \DB::table('grades')->where('class_id', $oldId)->update(['class_id' => $newId + 30000]);
        }
        
        // Update classes table
        foreach ($idMapping as $oldId => $newId) {
            \DB::table('classes')->where('id', $oldId)->update(['id' => $newId + 30000]);
        }
        
        // Fix the temporary IDs
        foreach ($idMapping as $oldId => $newId) {
            // Fix payments
            \DB::table('payments')->where('class_id', $newId + 30000)->update(['class_id' => $newId]);
            
            // Fix enrollments
            \DB::table('enrollments')->where('class_id', $newId + 30000)->update(['class_id' => $newId]);
            
            // Fix video_contents
            \DB::table('video_contents')->where('class_id', $newId + 30000)->update(['class_id' => $newId]);
            
            // Fix tasks
            \DB::table('tasks')->where('class_id', $newId + 30000)->update(['class_id' => $newId]);
            
            // Fix grades
            \DB::table('grades')->where('class_id', $newId + 30000)->update(['class_id' => $newId]);
            
            // Fix classes
            \DB::table('classes')->where('id', $newId + 30000)->update(['id' => $newId]);
        }
        
        // Re-enable foreign key checks
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        $this->info('✅ Classes ID gaps fixed!');
        
        // Show result
        $classes = Classes::orderBy('id')->get(['id', 'title']);
        $this->info('Updated Classes IDs:');
        foreach ($classes as $class) {
            $this->info("  ID {$class->id}: {$class->title}");
        }
        
        return Command::SUCCESS;
    }
}
