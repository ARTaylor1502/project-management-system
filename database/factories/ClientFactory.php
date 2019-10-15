<?php

use Carbon\Carbon;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Client::class, function (Faker $faker) {
    return [
        'name'                  =>  $faker->company,
        'landline_tele'         =>  $faker->phoneNumber,
        'mobile_number'         =>  $faker->phoneNumber,
        'website'               =>  $faker->url,
        'company_colour'        =>  $faker->hexcolor,
        'account_manager_id'    =>  App\User::inRandomOrder()->first()->value('id'),
        'client_type_id'        =>  App\ClientType::inRandomOrder()->first()->value('id'),
        'private_notes'         =>  $faker->text(200),
        'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
        'updated_at'            => Carbon::now()->format('Y-m-d H:i:s')
    ];
});
