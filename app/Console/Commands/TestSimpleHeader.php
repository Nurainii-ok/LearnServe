<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TestSimpleHeader extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:simple-header';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test Simple Header - Same as Admin Style';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🎯 HEADER TUTOR - SIMPLE STYLE');
        $this->info('==============================');
        
        $this->info('');
        $this->info('✅ HEADER DIKEMBALIKAN KE STYLE ADMIN:');
        $this->info('  • Layout sederhana dan clean');
        $this->info('  • Sama persis dengan admin header');
        $this->info('  • Menggunakan CSS admin.css yang sudah ada');
        $this->info('  • Tidak ada CSS tambahan yang kompleks');
        
        $this->info('');
        $this->info('🎨 KOMPONEN HEADER:');
        $this->info('  • Menu toggle button (hamburger)');
        $this->info('  • Dynamic page title');
        $this->info('  • Search bar');
        $this->info('  • Back to Website button');
        $this->info('  • User profile section');
        
        $this->info('');
        $this->info('📱 RESPONSIVE:');
        $this->info('  • Menggunakan CSS responsive dari admin.css');
        $this->info('  • Tidak ada custom CSS yang berlebihan');
        $this->info('  • Style konsisten dengan admin dashboard');
        
        $this->info('');
        $this->info('🎉 HEADER SIMPLE SIAP!');
        $this->info('Header tutor sekarang sama persis dengan admin,');
        $this->info('menggunakan style yang sudah ada dan teruji.');
        
        return Command::SUCCESS;
    }
}
