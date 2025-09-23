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
        // Disable foreign key checks temporarily
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Drop foreign key constraints temporarily
        $this->dropForeignKeys();
        
        // Reorganize Classes IDs to be sequential starting from 1
        $this->reorganizeClassesIds();
        
        // Reorganize Bootcamps IDs to be sequential starting from 1
        $this->reorganizeBootcampsIds();
        
        // Modify tables to remove auto-increment
        Schema::table('classes', function (Blueprint $table) {
            $table->bigInteger('id')->change();
        });
        
        Schema::table('bootcamps', function (Blueprint $table) {
            $table->bigInteger('id')->change();
        });
        
        // Recreate foreign key constraints
        $this->recreateForeignKeys();
        
        // Re-enable foreign key checks
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Restore auto-increment
        Schema::table('classes', function (Blueprint $table) {
            $table->id()->change();
        });
        
        Schema::table('bootcamps', function (Blueprint $table) {
            $table->id()->change();
        });
    }
    
    /**
     * Reorganize Classes IDs to be sequential starting from 1
     */
    private function reorganizeClassesIds()
    {
        // Get all classes ordered by creation date
        $classes = \DB::table('classes')->orderBy('created_at')->get();
        
        // Create temporary mapping
        $idMapping = [];
        $newId = 1;
        
        foreach ($classes as $class) {
            $idMapping[$class->id] = $newId;
            $newId++;
        }
        
        // Update related tables first
        foreach ($idMapping as $oldId => $newId) {
            if ($oldId != $newId) {
                // Update payments
                \DB::table('payments')->where('class_id', $oldId)->update(['class_id' => $newId + 10000]);
                
                // Update enrollments
                \DB::table('enrollments')->where('class_id', $oldId)->update(['class_id' => $newId + 10000]);
                
                // Update video_contents
                \DB::table('video_contents')->where('class_id', $oldId)->update(['class_id' => $newId + 10000]);
                
                // Update tasks
                \DB::table('tasks')->where('class_id', $oldId)->update(['class_id' => $newId + 10000]);
                
                // Update grades
                \DB::table('grades')->where('class_id', $oldId)->update(['class_id' => $newId + 10000]);
            }
        }
        
        // Update classes table
        foreach ($idMapping as $oldId => $newId) {
            if ($oldId != $newId) {
                \DB::table('classes')->where('id', $oldId)->update(['id' => $newId + 10000]);
            }
        }
        
        // Fix the temporary IDs
        foreach ($idMapping as $oldId => $newId) {
            if ($oldId != $newId) {
                // Fix payments
                \DB::table('payments')->where('class_id', $newId + 10000)->update(['class_id' => $newId]);
                
                // Fix enrollments
                \DB::table('enrollments')->where('class_id', $newId + 10000)->update(['class_id' => $newId]);
                
                // Fix video_contents
                \DB::table('video_contents')->where('class_id', $newId + 10000)->update(['class_id' => $newId]);
                
                // Fix tasks
                \DB::table('tasks')->where('class_id', $newId + 10000)->update(['class_id' => $newId]);
                
                // Fix grades
                \DB::table('grades')->where('class_id', $newId + 10000)->update(['class_id' => $newId]);
                
                // Fix classes
                \DB::table('classes')->where('id', $newId + 10000)->update(['id' => $newId]);
            }
        }
    }
    
    /**
     * Reorganize Bootcamps IDs to be sequential starting from 1
     */
    private function reorganizeBootcampsIds()
    {
        // Get all bootcamps ordered by creation date
        $bootcamps = \DB::table('bootcamps')->orderBy('created_at')->get();
        
        // Create temporary mapping
        $idMapping = [];
        $newId = 1;
        
        foreach ($bootcamps as $bootcamp) {
            $idMapping[$bootcamp->id] = $newId;
            $newId++;
        }
        
        // Update related tables first
        foreach ($idMapping as $oldId => $newId) {
            if ($oldId != $newId) {
                // Update payments
                \DB::table('payments')->where('bootcamp_id', $oldId)->update(['bootcamp_id' => $newId + 10000]);
                
                // Update enrollments
                \DB::table('enrollments')->where('bootcamp_id', $oldId)->update(['bootcamp_id' => $newId + 10000]);
                
                // Update video_contents
                \DB::table('video_contents')->where('bootcamp_id', $oldId)->update(['bootcamp_id' => $newId + 10000]);
            }
        }
        
        // Update bootcamps table
        foreach ($idMapping as $oldId => $newId) {
            if ($oldId != $newId) {
                \DB::table('bootcamps')->where('id', $oldId)->update(['id' => $newId + 10000]);
            }
        }
        
        // Fix the temporary IDs
        foreach ($idMapping as $oldId => $newId) {
            if ($oldId != $newId) {
                // Fix payments
                \DB::table('payments')->where('bootcamp_id', $newId + 10000)->update(['bootcamp_id' => $newId]);
                
                // Fix enrollments
                \DB::table('enrollments')->where('bootcamp_id', $newId + 10000)->update(['bootcamp_id' => $newId]);
                
                // Fix video_contents
                \DB::table('video_contents')->where('bootcamp_id', $newId + 10000)->update(['bootcamp_id' => $newId]);
                
                // Fix bootcamps
                \DB::table('bootcamps')->where('id', $newId + 10000)->update(['id' => $newId]);
            }
        }
    }
    
    /**
     * Drop foreign key constraints temporarily
     */
    private function dropForeignKeys()
    {
        try {
            // Drop foreign keys that reference classes.id
            \DB::statement('ALTER TABLE tasks DROP FOREIGN KEY tasks_class_id_foreign');
            \DB::statement('ALTER TABLE payments DROP FOREIGN KEY payments_class_id_foreign');
            \DB::statement('ALTER TABLE enrollments DROP FOREIGN KEY enrollments_class_id_foreign');
            \DB::statement('ALTER TABLE video_contents DROP FOREIGN KEY video_contents_class_id_foreign');
            \DB::statement('ALTER TABLE grades DROP FOREIGN KEY grades_class_id_foreign');
            
            // Drop foreign keys that reference bootcamps.id
            \DB::statement('ALTER TABLE payments DROP FOREIGN KEY payments_bootcamp_id_foreign');
            \DB::statement('ALTER TABLE enrollments DROP FOREIGN KEY enrollments_bootcamp_id_foreign');
            \DB::statement('ALTER TABLE video_contents DROP FOREIGN KEY video_contents_bootcamp_id_foreign');
        } catch (\Exception $e) {
            // Some foreign keys might not exist, continue anyway
        }
    }
    
    /**
     * Recreate foreign key constraints
     */
    private function recreateForeignKeys()
    {
        try {
            // Recreate foreign keys for classes
            \DB::statement('ALTER TABLE tasks ADD CONSTRAINT tasks_class_id_foreign FOREIGN KEY (class_id) REFERENCES classes(id) ON DELETE CASCADE');
            \DB::statement('ALTER TABLE payments ADD CONSTRAINT payments_class_id_foreign FOREIGN KEY (class_id) REFERENCES classes(id) ON DELETE CASCADE');
            \DB::statement('ALTER TABLE enrollments ADD CONSTRAINT enrollments_class_id_foreign FOREIGN KEY (class_id) REFERENCES classes(id) ON DELETE CASCADE');
            \DB::statement('ALTER TABLE video_contents ADD CONSTRAINT video_contents_class_id_foreign FOREIGN KEY (class_id) REFERENCES classes(id) ON DELETE CASCADE');
            \DB::statement('ALTER TABLE grades ADD CONSTRAINT grades_class_id_foreign FOREIGN KEY (class_id) REFERENCES classes(id) ON DELETE CASCADE');
            
            // Recreate foreign keys for bootcamps
            \DB::statement('ALTER TABLE payments ADD CONSTRAINT payments_bootcamp_id_foreign FOREIGN KEY (bootcamp_id) REFERENCES bootcamps(id) ON DELETE CASCADE');
            \DB::statement('ALTER TABLE enrollments ADD CONSTRAINT enrollments_bootcamp_id_foreign FOREIGN KEY (bootcamp_id) REFERENCES bootcamps(id) ON DELETE CASCADE');
            \DB::statement('ALTER TABLE video_contents ADD CONSTRAINT video_contents_bootcamp_id_foreign FOREIGN KEY (bootcamp_id) REFERENCES bootcamps(id) ON DELETE CASCADE');
        } catch (\Exception $e) {
            // Some foreign keys might already exist or have different names
        }
    }
};
