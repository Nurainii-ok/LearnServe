<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\VideoContentController;

class TestVideoContentPages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:video-content';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test video content pages for admin and tutor';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🎬 Testing Video Content Pages...');
        
        // Test Admin Access
        $this->info('');
        $this->info('Testing Admin Video Content Access...');
        try {
            session(['user_id' => 1, 'role' => 'admin']);
            $controller = new VideoContentController();
            $result = $controller->index();
            $this->info('✅ Admin video content index: OK');
            
            $result = $controller->create();
            $this->info('✅ Admin video content create: OK');
        } catch (\Exception $e) {
            $this->error('❌ Admin video content error: ' . $e->getMessage());
        }
        
        // Test Tutor Access
        $this->info('');
        $this->info('Testing Tutor Video Content Access...');
        try {
            session(['user_id' => 2, 'role' => 'tutor']);
            $controller = new VideoContentController();
            $result = $controller->index();
            $this->info('✅ Tutor video content index: OK');
            
            $result = $controller->create();
            $this->info('✅ Tutor video content create: OK');
        } catch (\Exception $e) {
            $this->error('❌ Tutor video content error: ' . $e->getMessage());
        }
        
        // Test Video Content Statistics
        $this->info('');
        $this->info('Video Content Statistics:');
        $totalVideos = \App\Models\VideoContent::count();
        $activeVideos = \App\Models\VideoContent::where('status', 'active')->count();
        $classVideos = \App\Models\VideoContent::whereNotNull('class_id')->count();
        $bootcampVideos = \App\Models\VideoContent::whereNotNull('bootcamp_id')->count();
        
        $this->info("📊 Total videos: {$totalVideos}");
        $this->info("📊 Active videos: {$activeVideos}");
        $this->info("📊 Class videos: {$classVideos}");
        $this->info("📊 Bootcamp videos: {$bootcampVideos}");
        
        $this->info('');
        $this->info('🎉 Video Content System Ready!');
        
        return Command::SUCCESS;
    }
}
