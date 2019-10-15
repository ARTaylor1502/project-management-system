<?php

use App\Client;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Carbon\Carbon;

class ClientsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('en_GB');

        DB::table('clients')->insert([
            'name'                  =>  'Pimms',
            'landline_tele'         =>  $faker->phoneNumber,
            'mobile_number'         =>  $faker->phoneNumber,
            'website'               =>  'https://pimms.co.uk',
            'company_colour'        =>  $faker->hexcolor,
            'account_manager_id'    =>  App\User::inRandomOrder()->first()->value('id'),
            'client_type_id'        =>  App\ClientType::inRandomOrder()->first()->value('id'),
            'private_notes'         => $faker->text(200),
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'            => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('clients')->insert([
            'name'                  =>  'Caeserstone',
            'landline_tele'         =>  $faker->phoneNumber,
            'mobile_number'         =>  $faker->phoneNumber,
            'website'               =>  'https://caeserstone.co.uk',
            'company_colour'        =>  $faker->hexcolor,
            'account_manager_id'    =>  App\User::inRandomOrder()->first()->value('id'),
            'client_type_id'        =>  App\ClientType::inRandomOrder()->first()->value('id'),
            'private_notes'         => $faker->text(200),
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'            => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('clients')->insert([
            'name'                  =>  'The Kennel Club',
            'landline_tele'         =>  $faker->phoneNumber,
            'mobile_number'         =>  $faker->phoneNumber,
            'website'               =>  'https://www.thekennelclub.org.uk',
            'company_colour'        =>  $faker->hexcolor,
            'account_manager_id'    =>  App\User::inRandomOrder()->first()->value('id'),
            'client_type_id'        =>  App\ClientType::inRandomOrder()->first()->value('id'),
            'private_notes'         => $faker->text(200),
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'            => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('clients')->insert([
            'name'                  =>  'MSD Animal Health',
            'landline_tele'         =>  $faker->phoneNumber,
            'mobile_number'         =>  $faker->phoneNumber,
            'website'               =>  'http://www.msd-animal-health.co.uk',
            'company_colour'        =>  $faker->hexcolor,
            'account_manager_id'    =>  App\User::inRandomOrder()->first()->value('id'),
            'client_type_id'        =>  App\ClientType::inRandomOrder()->first()->value('id'),
            'private_notes'         => $faker->text(200),
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'            => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        factory(App\Client::class, 50)->create();
    }
}
