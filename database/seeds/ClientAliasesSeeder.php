<?php

use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientAliasesSeeder extends Seeder
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
            DB::table('client_aliases')->insert([
                'client_id'          =>  $client->id,
                'name'               =>  $faker->name,
                'created_at'         => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'         => Carbon::now()->format('Y-m-d H:i:s')
            ]);

            DB::table('client_aliases')->insert([
                'client_id'          =>  $client->id,
                'name'               =>  $faker->name,
                'created_at'         => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'         => Carbon::now()->format('Y-m-d H:i:s')
            ]);

            DB::table('client_aliases')->insert([
                'client_id'          =>  $client->id,
                'name'               =>  $faker->name,
                'created_at'         => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'         => Carbon::now()->format('Y-m-d H:i:s')
            ]);
        }
    }
}
