<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CostTypes extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cost_types')->insert([
            'name'                  =>  'One-off'
        ]);

        DB::table('cost_types')->insert([
            'name'                  =>  'Per man per day'
        ]);

        DB::table('cost_types')->insert([
            'name'                  =>  'Per mile'
        ]);

        DB::table('cost_types')->insert([
            'name'                  =>  'Per hour'
        ]);

        DB::table('cost_types')->insert([
            'name'                  =>  'Per sq. meter'
        ]);
    }
}
