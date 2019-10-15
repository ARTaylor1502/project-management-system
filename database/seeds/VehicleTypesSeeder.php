<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VehicleTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('vehicle_types')->insert([
            'name'                  =>  'Car'
        ]);

        DB::table('vehicle_types')->insert([
            'name'                  =>  'LGV'
        ]);

        DB::table('vehicle_types')->insert([
            'name'                  =>  'HGV'
        ]);
    }
}
