<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date_one = strtotime('+1 months');

        DB::table('events')->insert([
            'name'                  =>  'Crufts',
            'start_date'            =>  date('y-m-d', $date_one),
            'end_date'              =>  date('y-m-d', strtotime(date('Y-m-d', $date_one). ' + 3 days')),
            'primary_venue_id'      =>  DB::table('venues')->where('name', 'National Exhibition Centre (NEC)')->value('id'),
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'            => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        $date_two = strtotime('+2 months');

        DB::table('events')->insert([
            'name'                  =>  'KBB 2019',
            'start_date'            =>  date('y-m-d', $date_two),
            'end_date'              =>  date('y-m-d', strtotime(date('Y-m-d', $date_two). ' + 2 days')),
            'primary_venue_id'      =>  DB::table('venues')->where('name', 'National Exhibition Centre (NEC)')->value('id'),
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'            => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        $date_three = strtotime('+3 months');

        DB::table('events')->insert([
            'name'                  =>  'Wimbledon 2019',
            'start_date'            =>  date('y-m-d', $date_three),
            'end_date'              =>  date('y-m-d', strtotime(date('Y-m-d', $date_three). ' + 14 days')),
            'primary_venue_id'      =>  DB::table('venues')->where('name', 'All England Lawn Tennis & Croquet Club')->value('id'),
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'            => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        $date_four = strtotime('+4 months');

        DB::table('events')->insert([
            'name'                  =>  'Pig & Poultry 2019',
            'start_date'            =>  date('y-m-d', $date_four),
            'end_date'              =>  date('y-m-d', strtotime(date('Y-m-d', $date_four). ' + 2 days')),
            'primary_venue_id'      =>  DB::table('venues')->where('name', 'NAEC Stoneleigh')->value('id'),
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'            => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}
