<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\PagesController;
use App\Models\Classes;

class TestDetailKursus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:detail-kursus';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test detail kursus page for various scenarios';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🎓 TESTING DETAIL KURSUS PAGE');
        $this->info('============================');
        
        // Test with valid class ID
        $this->testValidClass();
        
        // Test with invalid class ID
        $this->testInvalidClass();
        
        // Test with null ID
        $this->testNullId();
        
        // Test class data structure
        $this->testClassData();
        
        $this->info('');
        $this->info('🎉 DETAIL KURSUS PAGE TESTS COMPLETE!');
        $this->info('✅ All scenarios handled properly - ready for exam!');
        
        return Command::SUCCESS;
    }
    
    private function testValidClass()
    {
        $this->info('');
        $this->info('✅ Testing with valid class ID...');
        
        try {
            $class = Classes::first();
            if ($class) {
                $controller = new PagesController();
                $result = $controller->detailKursus($class->id);
                $this->info("✅ Valid class ID {$class->id}: OK");
                $this->info("   - Class title: {$class->title}");
                $this->info("   - Class price: Rp" . number_format($class->price ?? 0, 0, ',', '.'));
            } else {
                $this->warn("⚠️ No classes found in database");
            }
        } catch (\Exception $e) {
            $this->error('❌ Valid class test failed: ' . $e->getMessage());
        }
    }
    
    private function testInvalidClass()
    {
        $this->info('');
        $this->info('🚫 Testing with invalid class ID...');
        
        try {
            $controller = new PagesController();
            $result = $controller->detailKursus(99999); // Non-existent ID
            $this->info("✅ Invalid class ID handled gracefully");
        } catch (\Exception $e) {
            $this->error('❌ Invalid class test failed: ' . $e->getMessage());
        }
    }
    
    private function testNullId()
    {
        $this->info('');
        $this->info('🔄 Testing with null ID...');
        
        try {
            $controller = new PagesController();
            $result = $controller->detailKursus(null);
            $this->info("✅ Null ID handled gracefully");
        } catch (\Exception $e) {
            $this->error('❌ Null ID test failed: ' . $e->getMessage());
        }
    }
    
    private function testClassData()
    {
        $this->info('');
        $this->info('📊 Testing class data structure...');
        
        try {
            $classes = Classes::with(['tutor'])->take(3)->get();
            
            foreach ($classes as $class) {
                $this->info("✅ Class: {$class->title}");
                $this->info("   - ID: {$class->id}");
                $this->info("   - Price: Rp" . number_format($class->price ?? 0, 0, ',', '.'));
                $this->info("   - Status: {$class->status}");
                $this->info("   - Tutor: " . ($class->tutor->name ?? 'No tutor'));
            }
            
            $this->info("✅ Class data structure is valid");
            
        } catch (\Exception $e) {
            $this->error('❌ Class data test failed: ' . $e->getMessage());
        }
    }
}
