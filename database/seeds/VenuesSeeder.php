<?php

use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VenuesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('venues')->insert([
            'name'                  =>  'National Exhibition Centre (NEC)',
            'address_first_line'    =>  'North Ave',
            'address_second_line'   =>  'Marston Green',
            'address_town'          =>  'Birmingham',
            'address_county'        =>  'West Midlands',
            'address_postcode'      =>  'B40 1NT',
            'what3words_code'       =>  'winks.remove.raced',
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'            => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('venues')->insert([
            'name'                  =>  'All England Lawn Tennis & Croquet Club',
            'address_first_line'    =>  'Church Rd',
            'address_second_line'   =>  NULL,
            'address_town'          =>  'Wimbledon',
            'address_county'        =>  'London',
            'address_postcode'      =>  'SW19 5AE',
            'what3words_code'       =>  'wage.saves.cliff',
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'            => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('venues')->insert([
            'name'                  =>  'NAEC Stoneleigh',
            'address_first_line'    =>  'Stoneleigh Park',
            'address_second_line'   =>  NULL,
            'address_town'          =>  'Kenilworth',
            'address_county'        =>  'Warwickshire',
            'address_postcode'      =>  'CV8 2LG',
            'what3words_code'       =>  'freed.chair.basket',
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'            => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}
