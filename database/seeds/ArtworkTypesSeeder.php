<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ArtworkTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('artwork_types')->insert([
            'name'    =>  'Site Survey'
        ]);

        DB::table('artwork_types')->insert([
            'name'    =>  'Design & Concept'
        ]);

        DB::table('artwork_types')->insert([
            'name'    =>  'Artwork'
        ]);

        DB::table('artwork_types')->insert([
            'name'    =>  'Event Photo'
        ]);
    }
}
