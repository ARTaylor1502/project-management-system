<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CarParkTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('car_park_types')->insert([
            'name'                  =>  'Small Car Park'
        ]);

        DB::table('car_park_types')->insert([
            'name'                  =>  'Large Car Park'
        ]);
    }
}
