<?php

use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('en_GB');

        $client_id = DB::table('clients')->where('name', 'Pimms')->value('id');

        DB::table('client_users')->insert([
            'client_id' =>  $client_id,
            'title_id' =>  DB::table('user_titles')->where('name', 'Mr')->value('id'),
            'first_name' => 'Alex',
            'last_name' => 'Taylor',
            'email' => 'alex@formationmedia.co.uk',
            'landline_tele' =>  $faker->phoneNumber,
            'mobile_tele'   =>  $faker->phoneNumber,
            'password' => bcrypt('secret'),
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'            => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}
