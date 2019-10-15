<?php

use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientAddressesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('en_GB');

        $clients = DB::table('clients')->get();

        foreach($clients as $client) {

            DB::table('client_addresses')->insert([
                'client_id'             =>  $client->id,
                'is_primary_address'    =>  1,
                'address_name'          =>  'Head Quarters',
                'address_first_line'    =>  $faker->buildingNumber . ' ' . $faker->streetName,
                'address_second_line'   =>  $faker->buildingNumber,
                'address_town'          =>  $faker->city,
                'address_county'        =>  '',
                'address_postcode'      =>  $faker->postcode,
                'created_at'         => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'         => Carbon::now()->format('Y-m-d H:i:s')
            ]);

            DB::table('client_addresses')->insert([
                'client_id'             =>  $client->id,
                'is_primary_address'    =>  0,
                'address_name'          =>  'Secondary Branch',
                'address_first_line'    =>  $faker->buildingNumber . ' ' . $faker->streetName,
                'address_second_line'   =>  $faker->buildingNumber,
                'address_town'          =>  $faker->city,
                'address_county'        =>  '',
                'address_postcode'      =>  $faker->postcode,
                'created_at'         => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'         => Carbon::now()->format('Y-m-d H:i:s')
            ]);

            DB::table('client_addresses')->insert([
                'client_id'             =>  $client->id,
                'is_primary_address'    =>  0,
                'address_name'          =>  'Third Branch',
                'address_first_line'    =>  $faker->buildingNumber . ' ' . $faker->streetName,
                'address_second_line'   =>  $faker->buildingNumber,
                'address_town'          =>  $faker->city,
                'address_county'        =>  '',
                'address_postcode'      =>  $faker->postcode,
                'created_at'         => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'         => Carbon::now()->format('Y-m-d H:i:s')
            ]);
        }
    }
}
