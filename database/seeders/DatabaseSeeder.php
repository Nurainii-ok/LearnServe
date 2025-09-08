<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use App\Models\Tutor;
use App\Models\Member;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // akun tetap
        Admin::factory()->dataadmin1()->create(); // admin: admin/admin
        Tutor::factory()->defaultTutor()->create(); // tutor: tutor/tutor
        Member::factory()->defaultMember()->create(); // member: member/member

        // dummy
        Admin::factory()->count(2)->create();
        Tutor::factory()->count(5)->create();
        Member::factory()->count(20)->create();
    }
}
