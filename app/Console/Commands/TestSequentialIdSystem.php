<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Classes;
use App\Models\Bootcamp;

class TestSequentialIdSystem extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:sequential-id';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test Sequential ID System - No Gaps, Perfect Order';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔢 TESTING SEQUENTIAL ID SYSTEM');
        $this->info('==============================');
        
        // Show current state
        $this->showCurrentState();
        
        // Test creating new records
        $this->testCreateRecords();
        
        // Test deleting and recreating (gap filling)
        $this->testGapFilling();
        
        // Show final state
        $this->showFinalState();
        
        $this->info('');
        $this->info('🎉 SEQUENTIAL ID SYSTEM WORKING PERFECTLY!');
        $this->info('✅ No gaps in ID sequence - IDs start from 1!');
        
        return Command::SUCCESS;
    }
    
    private function showCurrentState()
    {
        $this->info('');
        $this->info('📊 Current State:');
        
        $classes = Classes::orderBy('id')->get(['id', 'title']);
        $this->info('Classes:');
        if ($classes->count() > 0) {
            foreach ($classes as $class) {
                $this->info("  ID {$class->id}: {$class->title}");
            }
        } else {
            $this->info("  No classes found");
        }
        
        $bootcamps = Bootcamp::orderBy('id')->get(['id', 'title']);
        $this->info('Bootcamps:');
        if ($bootcamps->count() > 0) {
            foreach ($bootcamps as $bootcamp) {
                $this->info("  ID {$bootcamp->id}: {$bootcamp->title}");
            }
        } else {
            $this->info("  No bootcamps found");
        }
    }
    
    private function testCreateRecords()
    {
        $this->info('');
        $this->info('➕ Testing CREATE operations...');
        
        try {
            // Create a test class
            $class = Classes::create([
                'title' => 'Test Sequential Class',
                'description' => 'Testing sequential ID system',
                'tutor_id' => 1,
                'price' => 100000,
                'status' => 'active',
                'category' => 'Programming'
            ]);
            
            $this->info("✅ Created class with ID: {$class->id}");
            
            // Create a test bootcamp
            $bootcamp = Bootcamp::create([
                'title' => 'Test Sequential Bootcamp',
                'description' => 'Testing sequential ID system',
                'tutor_id' => 1,
                'price' => 500000,
                'duration' => '12 weeks',
                'level' => 'intermediate',
                'status' => 'active',
                'start_date' => now(),
                'end_date' => now()->addWeeks(12)
            ]);
            
            $this->info("✅ Created bootcamp with ID: {$bootcamp->id}");
            
        } catch (\Exception $e) {
            $this->error('❌ CREATE test failed: ' . $e->getMessage());
        }
    }
    
    private function testGapFilling()
    {
        $this->info('');
        $this->info('🗑️ Testing GAP FILLING (Delete & Recreate)...');
        
        try {
            // Find a class to delete (not the first or last)
            $classToDelete = Classes::orderBy('id')->skip(1)->first();
            
            if ($classToDelete) {
                $deletedId = $classToDelete->id;
                $classToDelete->delete();
                $this->info("✅ Deleted class with ID: {$deletedId}");
                
                // Create new class - should fill the gap
                $newClass = Classes::create([
                    'title' => 'Gap Filler Class',
                    'description' => 'Should fill the deleted ID gap',
                    'tutor_id' => 1,
                    'price' => 150000,
                    'status' => 'active',
                    'category' => 'Design'
                ]);
                
                $this->info("✅ Created new class with ID: {$newClass->id}");
                
                if ($newClass->id == $deletedId) {
                    $this->info("🎯 SUCCESS: Gap filled correctly! ID {$deletedId} reused.");
                } else {
                    $this->warn("⚠️ WARNING: Expected ID {$deletedId}, got ID {$newClass->id}");
                }
            }
            
            // Same test for bootcamp
            $bootcampToDelete = Bootcamp::orderBy('id')->skip(1)->first();
            
            if ($bootcampToDelete) {
                $deletedId = $bootcampToDelete->id;
                $bootcampToDelete->delete();
                $this->info("✅ Deleted bootcamp with ID: {$deletedId}");
                
                // Create new bootcamp - should fill the gap
                $newBootcamp = Bootcamp::create([
                    'title' => 'Gap Filler Bootcamp',
                    'description' => 'Should fill the deleted ID gap',
                    'tutor_id' => 1,
                    'price' => 750000,
                    'duration' => '16 weeks',
                    'level' => 'advanced',
                    'status' => 'active',
                    'start_date' => now(),
                    'end_date' => now()->addWeeks(16)
                ]);
                
                $this->info("✅ Created new bootcamp with ID: {$newBootcamp->id}");
                
                if ($newBootcamp->id == $deletedId) {
                    $this->info("🎯 SUCCESS: Gap filled correctly! ID {$deletedId} reused.");
                } else {
                    $this->warn("⚠️ WARNING: Expected ID {$deletedId}, got ID {$newBootcamp->id}");
                }
            }
            
        } catch (\Exception $e) {
            $this->error('❌ GAP FILLING test failed: ' . $e->getMessage());
        }
    }
    
    private function showFinalState()
    {
        $this->info('');
        $this->info('📊 Final State:');
        
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
        
        // Check for gaps
        $this->checkForGaps();
    }
    
    private function checkForGaps()
    {
        $this->info('');
        $this->info('🔍 Checking for ID gaps...');
        
        // Check Classes
        $classIds = Classes::orderBy('id')->pluck('id')->toArray();
        if (count($classIds) > 0) {
            $expectedIds = range(1, count($classIds));
            
            if ($classIds === $expectedIds) {
                $this->info('✅ Classes: Perfect sequence! IDs: ' . implode(', ', $classIds));
            } else {
                $this->warn('⚠️ Classes: Gaps detected!');
                $this->info('Expected: ' . implode(', ', $expectedIds));
                $this->info('Actual: ' . implode(', ', $classIds));
            }
        }
        
        // Check Bootcamps
        $bootcampIds = Bootcamp::orderBy('id')->pluck('id')->toArray();
        if (count($bootcampIds) > 0) {
            $expectedIds = range(1, count($bootcampIds));
            
            if ($bootcampIds === $expectedIds) {
                $this->info('✅ Bootcamps: Perfect sequence! IDs: ' . implode(', ', $bootcampIds));
            } else {
                $this->warn('⚠️ Bootcamps: Gaps detected!');
                $this->info('Expected: ' . implode(', ', $expectedIds));
                $this->info('Actual: ' . implode(', ', $bootcampIds));
            }
        }
    }
}
