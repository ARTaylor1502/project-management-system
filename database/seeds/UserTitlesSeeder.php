<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTitlesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_titles')->insert([
            'name' =>  'Mr',
        ]);

        DB::table('user_titles')->insert([
            'name' =>  'Mrs',
        ]);

        DB::table('user_titles')->insert([
            'name' =>  'Ms',
        ]);

        DB::table('user_titles')->insert([
            'name' =>  'Miss',
        ]);

        DB::table('user_titles')->insert([
            'name' =>  'Dr',
        ]);
    }
}
