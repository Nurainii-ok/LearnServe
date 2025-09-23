<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Bootcamp;

class FixBootcampGaps extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:bootcamp-gaps';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix gaps in bootcamp IDs to make them sequential';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔧 Fixing Bootcamp ID gaps...');
        
        // Disable foreign key checks
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Get all bootcamps ordered by ID
        $bootcamps = Bootcamp::orderBy('id')->get();
        
        $this->info("Found {$bootcamps->count()} bootcamps");
        
        // Create ID mapping
        $idMapping = [];
        $newId = 1;
        
        foreach ($bootcamps as $bootcamp) {
            if ($bootcamp->id != $newId) {
                $idMapping[$bootcamp->id] = $newId;
                $this->info("Will change ID {$bootcamp->id} -> {$newId}: {$bootcamp->title}");
            }
            $newId++;
        }
        
        // Update related tables first
        foreach ($idMapping as $oldId => $newId) {
            // Update payments
            \DB::table('payments')->where('bootcamp_id', $oldId)->update(['bootcamp_id' => $newId + 20000]);
            
            // Update enrollments
            \DB::table('enrollments')->where('bootcamp_id', $oldId)->update(['bootcamp_id' => $newId + 20000]);
            
            // Update video_contents
            \DB::table('video_contents')->where('bootcamp_id', $oldId)->update(['bootcamp_id' => $newId + 20000]);
        }
        
        // Update bootcamps table
        foreach ($idMapping as $oldId => $newId) {
            \DB::table('bootcamps')->where('id', $oldId)->update(['id' => $newId + 20000]);
        }
        
        // Fix the temporary IDs
        foreach ($idMapping as $oldId => $newId) {
            // Fix payments
            \DB::table('payments')->where('bootcamp_id', $newId + 20000)->update(['bootcamp_id' => $newId]);
            
            // Fix enrollments
            \DB::table('enrollments')->where('bootcamp_id', $newId + 20000)->update(['bootcamp_id' => $newId]);
            
            // Fix video_contents
            \DB::table('video_contents')->where('bootcamp_id', $newId + 20000)->update(['bootcamp_id' => $newId]);
            
            // Fix bootcamps
            \DB::table('bootcamps')->where('id', $newId + 20000)->update(['id' => $newId]);
        }
        
        // Re-enable foreign key checks
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        $this->info('✅ Bootcamp ID gaps fixed!');
        
        // Show result
        $bootcamps = Bootcamp::orderBy('id')->get(['id', 'title']);
        $this->info('Updated Bootcamp IDs:');
        foreach ($bootcamps as $bootcamp) {
            $this->info("  ID {$bootcamp->id}: {$bootcamp->title}");
        }
        
        return Command::SUCCESS;
    }
}
