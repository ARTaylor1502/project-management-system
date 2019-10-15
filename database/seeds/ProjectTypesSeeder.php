<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('project_types')->insert([
            'name'    =>  'Exhibition Stand'
        ]);

        DB::table('project_types')->insert([
            'name'    =>  'Outdoor Exhibition Stand'
        ]);

        DB::table('project_types')->insert([
            'name'    =>  'Permanent Fit-out'
        ]);

        DB::table('project_types')->insert([
            'name'    =>  'Experiential Activation'
        ]);

        DB::table('project_types')->insert([
            'name'    =>  'Signage/Branding'
        ]);

        DB::table('project_types')->insert([
            'name'    =>  'Artwork Only'
        ]);

        DB::table('project_types')->insert([
            'name'    =>  'Design Only'
        ]);

        DB::table('project_types')->insert([
            'name'    =>  'Manufacture Only'
        ]);

        DB::table('project_types')->insert([
            'name'      =>  'Courier/Delivery'
        ]);
    }
}
