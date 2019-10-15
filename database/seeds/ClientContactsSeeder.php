<?php

use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientContactsSeeder extends Seeder
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

        foreach ($clients as $client) {
            DB::table('client_contacts')->insert([
                'client_id'             => $client->id,
                'is_primary_contact'    => 1,
                'first_name'            => $faker->firstName,
                'last_name'             => $faker->lastName,
                'email'                 => $faker->email,
                'landline_tele'         => $faker->phoneNumber,
                'mobile_number'         => $faker->phoneNumber,
                'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'            => Carbon::now()->format('Y-m-d H:i:s')
            ]);

            DB::table('client_contacts')->insert([
                'client_id'             => $client->id,
                'is_primary_contact'    => 0,
                'first_name'            => $faker->firstName,
                'last_name'             => $faker->lastName,
                'email'                 => $faker->email,
                'landline_tele'         => $faker->phoneNumber,
                'mobile_number'         => $faker->phoneNumber,
                'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'            => Carbon::now()->format('Y-m-d H:i:s')
            ]);

            DB::table('client_contacts')->insert([
                'client_id'             => $client->id,
                'is_primary_contact'    => 0,
                'first_name'            => $faker->firstName,
                'last_name'             => $faker->lastName,
                'email'                 => $faker->email,
                'landline_tele'         => $faker->phoneNumber,
                'mobile_number'         => $faker->phoneNumber,
                'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'            => Carbon::now()->format('Y-m-d H:i:s')
            ]);
        }
    }
}
