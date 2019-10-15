<?php

use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserAddressesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('en_GB');

        $users = DB::table('users')->get();

        foreach($users as $user) {

            DB::table('user_addresses')->insert([
                'user_id'               =>  $user->id,
                'address_name'          =>  'Home Address',
                'is_primary_address'    =>  1,
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
