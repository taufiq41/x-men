<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisKelaminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('jenis_kelamin')->insert([
            ['jenis_kelamin' => 'L','nama'          => 'Laki - Laki'],
            ['jenis_kelamin' => 'P','nama'          => 'Perempuan'],   
        ]);
    }
}
