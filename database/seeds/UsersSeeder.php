<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('en_GB');

        $department_id = DB::table('departments')->where('name', 'Design')->value('id');
        DB::table('users')->insert([
            'department_id' =>  $department_id,
            'role_id' =>  DB::table('user_roles')->where('name', 'Staff')->value('id'),
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

        $department_id = DB::table('departments')->where('name', 'Pre-Ops')->value('id');
        DB::table('users')->insert([
            'department_id' =>  $department_id,
            'role_id' =>  DB::table('user_roles')->where('name', 'Staff')->value('id'),
            'title_id' =>  DB::table('user_titles')->where('name', 'Mr')->value('id'),
            'first_name' => 'Jason',
            'last_name' => 'Millis',
            'email' => 'jason@formationmedia.co.uk',
            'landline_tele' =>  $faker->phoneNumber,
            'mobile_tele'   =>  $faker->phoneNumber,
            'password' => bcrypt('secret'),
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'            => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        $department_id = DB::table('departments')->where('name', 'Health & Safety')->value('id');
        DB::table('users')->insert([
            'department_id' =>  $department_id,
            'role_id' =>  DB::table('user_roles')->where('name', 'Staff')->value('id'),
            'title_id' =>  DB::table('user_titles')->where('name', 'Mrs')->value('id'),
            'first_name' => 'Test',
            'last_name' => 'Person',
            'email' => 'test@gmail.com',
            'landline_tele' =>  $faker->phoneNumber,
            'mobile_tele'   =>  $faker->phoneNumber,
            'password' => bcrypt('secret'),
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'            => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('users')->insert([
            'role_id' =>  DB::table('user_roles')->where('name', 'Contractor')->value('id'),
            'title_id' =>  DB::table('user_titles')->where('name', 'Miss')->value('id'),
            'first_name' => 'Test',
            'last_name' => 'Client',
            'email' => 'test2@gmail.com',
            'landline_tele' =>  $faker->phoneNumber,
            'mobile_tele'   =>  $faker->phoneNumber,
            'password' => bcrypt('secret'),
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'            => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('users')->insert([
            'role_id' =>  DB::table('user_roles')->where('name', 'Contractor')->value('id'),
            'title_id' =>  DB::table('user_titles')->where('name', 'Ms')->value('id'),
            'first_name' => 'Test',
            'last_name' => 'Contractor',
            'email' => 'test3@gmail.com',
            'landline_tele' =>  $faker->phoneNumber,
            'mobile_tele'   =>  $faker->phoneNumber,
            'password' => bcrypt('secret'),
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'            => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('users')->insert([
            'role_id' =>  DB::table('user_roles')->where('name', 'Supplier')->value('id'),
            'title_id' =>  DB::table('user_titles')->where('name', 'Mr')->value('id'),
            'first_name' => 'Test',
            'last_name' => 'Supplier',
            'email' => 'test4@gmail.com',
            'landline_tele' =>  $faker->phoneNumber,
            'mobile_tele'   =>  $faker->phoneNumber,
            'password' => bcrypt('secret'),
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'            => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}
