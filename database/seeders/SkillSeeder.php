<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('skills')->insert([
            ['nama' => 'Tembak Laser'],
            ['nama' => 'Terbang'],
            ['nama' => 'Jaring Laba-laba'],
            ['nama' => 'Lari secepat Kilat'],   
        ]);
    }
}
