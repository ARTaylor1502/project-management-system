<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectStatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('project_statuses')->insert([
            'name'    =>  'Enquiry',
        ]);

        DB::table('project_statuses')->insert([
            'name'    =>  'Active',
        ]);

        DB::table('project_statuses')->insert([
            'name'    =>  'Breakdown',
        ]);

        DB::table('project_statuses')->insert([
            'name'    =>  'In Approval',
        ]);

        DB::table('project_statuses')->insert([
            'name'    =>  'Closed',
        ]);
    }
}
