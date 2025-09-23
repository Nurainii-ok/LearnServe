<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Classes;
use App\Models\Bootcamp;

class CleanupTestData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cleanup:test-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cleanup test data created during sequential ID testing';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🧹 Cleaning up test data...');
        
        // Remove test classes
        $testClasses = Classes::where('title', 'LIKE', '%Test%')
                              ->orWhere('title', 'LIKE', '%Gap Filler%')
                              ->get();
        
        foreach ($testClasses as $class) {
            $this->info("Removing test class: {$class->title} (ID: {$class->id})");
            $class->delete();
        }
        
        // Remove test bootcamps
        $testBootcamps = Bootcamp::where('title', 'LIKE', '%Test%')
                                ->orWhere('title', 'LIKE', '%Gap Filler%')
                                ->get();
        
        foreach ($testBootcamps as $bootcamp) {
            $this->info("Removing test bootcamp: {$bootcamp->title} (ID: {$bootcamp->id})");
            $bootcamp->delete();
        }
        
        $this->info('✅ Test data cleanup completed!');
        
        // Show final clean state
        $this->info('');
        $this->info('📊 Final Clean State:');
        
        $classes = Classes::orderBy('id')->get(['id', 'title']);
        $this->info('Classes:');
        foreach ($classes as $class) {
            $this->info("  ID {$class->id}: {$class->title}");
        }
        
        $bootcamps = Bootcamp::orderBy('id')->get(['id', 'title']);
        $this->info('Bootcamps:');
        foreach ($bootcamps as $bootcamp) {
            $this->info("  ID {$bootcamp->id}: {$bootcamp->title}");
        }
        
        return Command::SUCCESS;
    }
}
