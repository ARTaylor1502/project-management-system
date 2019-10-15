<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class ProjectsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $event_id = DB::table('events')->where('name', 'Crufts')->value('id');
        $client_id = DB::table('clients')->where('name', 'Caeserstone')->value('id');
        $status_id = DB::table('project_statuses')->where('name', 'Active')->value('id');

        DB::table('projects')->insert([
            'event_id'              =>  $event_id,
            'client_id'             =>  $client_id,
            'project_owner_id'      =>  DB::table('users')->inRandomOrder()->first()->id,
            'client_contact_id'     =>  DB::table('client_contacts')->where('client_id', $client_id)->inRandomOrder()->first()->id,
            'status_id'             =>  $status_id,
            'venue_id'              =>  DB::table('venues')->where('name', 'National Exhibition Centre (NEC)')->value('id'),
            'name'                  =>  'Exhibition Stand',
            'project_type_id'       =>  DB::table('project_types')->where('name', 'Exhibition Stand')->value('id'),
            'brief'                 =>  '<p>Test</p>',
            'created_at'            =>  $faker->dateTimeBetween($startDate = 'now', $endDate = date('y-m-d', strtotime('+1 months'))),
            'updated_at'            =>  $faker->dateTimeBetween($startDate = 'now', date('y-m-d', strtotime('+1 months')))
        ]);

        $client_id = DB::table('clients')->where('name', 'The Kennel Club')->value('id');
        $status_id = DB::table('project_statuses')->where('name', 'Breakdown')->value('id');

        DB::table('projects')->insert([
            'event_id'              =>  $event_id,
            'client_id'             =>  $client_id,
            'project_owner_id'      =>  DB::table('users')->inRandomOrder()->first()->id,
            'client_contact_id'     =>  DB::table('client_contacts')->where('client_id', $client_id)->inRandomOrder()->first()->id,
            'status_id'             =>  $status_id,
            'venue_id'              =>  DB::table('venues')->where('name', 'National Exhibition Centre (NEC)')->value('id'),
            'name'                  =>  'Exhibition Stand 2',
            'project_type_id'       =>  DB::table('project_types')->where('name', 'Exhibition Stand')->value('id'),
            'brief'                 =>  '<p>Test</p>',
            'created_at'            =>  $faker->dateTimeBetween($startDate = 'now', $endDate = date('y-m-d', strtotime('+1 months'))),
            'updated_at'            =>  $faker->dateTimeBetween($startDate = 'now', date('y-m-d', strtotime('+1 months')))
        ]);

        $status_id = DB::table('project_statuses')->where('name', 'Enquiry')->value('id');

        DB::table('projects')->insert([
            'event_id'              =>  $event_id,
            'client_id'             =>  $client_id,
            'project_owner_id'      =>  DB::table('users')->inRandomOrder()->first()->id,
            'client_contact_id'     =>  DB::table('client_contacts')->where('client_id', $client_id)->inRandomOrder()->first()->id,
            'status_id'             =>  $status_id,
            'name'                  =>  'Exhibition Stand 3',
            'venue_id'              =>  DB::table('venues')->where('name', 'National Exhibition Centre (NEC)')->value('id'),
            'project_type_id'       =>  DB::table('project_types')->where('name', 'Exhibition Stand')->value('id'),
            'brief'                 =>  '<p>Test</p>',
            'created_at'            =>  $faker->dateTimeBetween($startDate = 'now', $endDate = date('y-m-d', strtotime('+1 months'))),
            'updated_at'            =>  $faker->dateTimeBetween($startDate = 'now', date('y-m-d', strtotime('+1 months')))
        ]);

        $event_id = DB::table('events')->where('name', 'KBB 2019')->value('id');
        $client_id = DB::table('clients')->where('name', 'MSD Animal Health')->value('id');
        $status_id = DB::table('project_statuses')->where('name', 'Active')->value('id');

        DB::table('projects')->insert([
            'event_id'              =>  $event_id,
            'client_id'             =>  $client_id,
            'project_owner_id'      =>  DB::table('users')->inRandomOrder()->first()->id,
            'client_contact_id'     =>  DB::table('client_contacts')->where('client_id', $client_id)->inRandomOrder()->first()->id,
            'status_id'             =>  $status_id,
            'venue_id'              =>  DB::table('venues')->where('name', 'National Exhibition Centre (NEC)')->value('id'),
            'name'                  =>  'Exhibition Stand',
            'project_type_id'       =>  DB::table('project_types')->where('name', 'Exhibition Stand')->value('id'),
            'brief'                 =>  '<p>Test</p>',
            'created_at'            =>  $faker->dateTimeBetween($startDate = 'now', $endDate = date('y-m-d', strtotime('+1 months'))),
            'updated_at'            =>  $faker->dateTimeBetween($startDate = 'now', date('y-m-d', strtotime('+1 months')))
        ]);

        $event_id = DB::table('events')->where('name', 'Wimbledon 2019')->value('id');
        $client_id = DB::table('clients')->where('name', 'Pimms')->value('id');
        $status_id = DB::table('project_statuses')->where('name', 'Active')->value('id');

        DB::table('projects')->insert([
            'event_id'              =>  $event_id,
            'client_id'             =>  $client_id,
            'project_owner_id'      =>  DB::table('users')->inRandomOrder()->first()->id,
            'client_contact_id'     =>  DB::table('client_contacts')->where('client_id', $client_id)->inRandomOrder()->first()->id,
            'status_id'             =>  $status_id,
            'venue_id'              =>  DB::table('venues')->where('name', 'All England Lawn Tennis & Croquet Club')->value('id'),
            'name'                  =>  'Bar Structure',
            'brief'                 =>  '<p>Test</p>',
            'project_type_id'       =>  DB::table('project_types')->where('name', ' Outdoor Exhibition Stand')->value('id'),
            'created_at'            =>  $faker->dateTimeBetween($startDate = 'now', $endDate = date('y-m-d', strtotime('+1 months'))),
            'updated_at'            =>  $faker->dateTimeBetween($startDate = 'now', date('y-m-d', strtotime('+1 months')))
        ]);

        $event_id = DB::table('events')->where('name', 'Pig & Poultry 2019')->value('id');
        $client_id = DB::table('clients')->where('name', 'Pimms')->value('id');
        $status_id = DB::table('project_statuses')->where('name', 'Active')->value('id');

        DB::table('projects')->insert([
            'event_id'              =>  $event_id,
            'client_id'             =>  $client_id,
            'project_owner_id'      =>  DB::table('users')->inRandomOrder()->first()->id,
            'client_contact_id'     =>  DB::table('client_contacts')->where('client_id', $client_id)->inRandomOrder()->first()->id,
            'status_id'             =>  $status_id,
            'venue_id'              =>  DB::table('venues')->where('name', 'NAEC Stoneleigh')->value('id'),
            'name'                  =>  'Exhibition Stand',
            'project_type_id'       =>  DB::table('project_types')->where('name', 'Outdoor Exhibition Stand')->value('id'),
            'brief'                 =>  '<p>Test</p>',
            'created_at'            =>  $faker->dateTimeBetween($startDate = 'now', $endDate = date('y-m-d', strtotime('+1 months'))),
            'updated_at'            =>  $faker->dateTimeBetween($startDate = 'now', date('y-m-d', strtotime('+1 months')))
        ]);
    }
}
