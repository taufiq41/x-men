<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Admin Super Heroes',
            'email' => 'heroslokal@gmail.com',
            'password' => bcrypt('berjuang')            
        ]);
    }
}
