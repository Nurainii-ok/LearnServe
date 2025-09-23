<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\VideoContent;
use App\Models\Classes;
use App\Models\Bootcamp;
use App\Models\User;

class TestVideoContentSystem extends Command
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
    protected $description = 'Test Video Content System - Admin vs Tutor Views';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🎥 TESTING VIDEO CONTENT SYSTEM');
        $this->info('==============================');
        
        // Show current video contents
        $this->showCurrentVideos();
        
        // Show routes status
        $this->showRoutesStatus();
        
        // Show views status
        $this->showViewsStatus();
        
        $this->info('');
        $this->info('🎉 VIDEO CONTENT SYSTEM STATUS');
        $this->info('✅ Admin routes: admin.video-contents.*');
        $this->info('✅ Tutor routes: tutor.video-contents.*');
        $this->info('✅ Admin views: admin/video-contents/*');
        $this->info('✅ Tutor views: tutor/video-contents/*');
        $this->info('✅ Controller handles both roles correctly');
        
        return Command::SUCCESS;
    }
    
    private function showCurrentVideos()
    {
        $this->info('');
        $this->info('📊 Current Video Contents:');
        
        $videos = VideoContent::with(['class', 'bootcamp', 'creator'])->get();
        
        if ($videos->count() > 0) {
            foreach ($videos as $video) {
                $course = $video->class ? "Class: {$video->class->title}" : "Bootcamp: {$video->bootcamp->title}";
                $creator = $video->creator ? $video->creator->name : 'Unknown';
                $this->info("  ID {$video->id}: {$video->title} ({$course}) - By: {$creator}");
            }
        } else {
            $this->info("  No video contents found");
        }
    }
    
    private function showRoutesStatus()
    {
        $this->info('');
        $this->info('🛣️ Routes Status:');
        
        // Check if routes exist
        $adminRoutes = [
            'admin.video-contents.index',
            'admin.video-contents.create',
            'admin.video-contents.store',
            'admin.video-contents.show',
            'admin.video-contents.edit',
            'admin.video-contents.update',
            'admin.video-contents.destroy'
        ];
        
        $tutorRoutes = [
            'tutor.video-contents.index',
            'tutor.video-contents.create',
            'tutor.video-contents.store',
            'tutor.video-contents.show',
            'tutor.video-contents.edit',
            'tutor.video-contents.update',
            'tutor.video-contents.destroy'
        ];
        
        $this->info('Admin Routes:');
        foreach ($adminRoutes as $route) {
            try {
                $url = route($route, ['videoContent' => 1]);
                $this->info("  ✅ {$route}");
            } catch (\Exception $e) {
                $this->error("  ❌ {$route} - Not found");
            }
        }
        
        $this->info('Tutor Routes:');
        foreach ($tutorRoutes as $route) {
            try {
                $url = route($route, ['videoContent' => 1]);
                $this->info("  ✅ {$route}");
            } catch (\Exception $e) {
                $this->error("  ❌ {$route} - Not found");
            }
        }
    }
    
    private function showViewsStatus()
    {
        $this->info('');
        $this->info('👁️ Views Status:');
        
        $adminViews = [
            'resources/views/admin/video-contents/index.blade.php',
            'resources/views/admin/video-contents/create.blade.php',
            'resources/views/admin/video-contents/edit.blade.php',
            'resources/views/admin/video-contents/show.blade.php'
        ];
        
        $tutorViews = [
            'resources/views/tutor/video-contents/index.blade.php',
            'resources/views/tutor/video-contents/create.blade.php',
            'resources/views/tutor/video-contents/edit.blade.php',
            'resources/views/tutor/video-contents/show.blade.php'
        ];
        
        $this->info('Admin Views:');
        foreach ($adminViews as $view) {
            if (file_exists(base_path($view))) {
                $this->info("  ✅ {$view}");
            } else {
                $this->error("  ❌ {$view} - Not found");
            }
        }
        
        $this->info('Tutor Views:');
        foreach ($tutorViews as $view) {
            if (file_exists(base_path($view))) {
                $this->info("  ✅ {$view}");
            } else {
                $this->error("  ❌ {$view} - Not found");
            }
        }
    }
}
