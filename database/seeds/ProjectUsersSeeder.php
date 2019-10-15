<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $project_id = DB::table('projects')->join('events', 'projects.event_id', '=', 'events.id')->where(['projects.name' => 'Exhibition Stand'],['events.name' => 'Crufts'])->value('projects.id');
        $user_id = DB::table('users')->where('email', 'alex@formationmedia.co.uk')->value('id');

        DB::table('project_users')->insert([
            'project_id'        =>  $project_id,
            'user_id'           =>  $user_id
        ]);

        $project_id = DB::table('projects')->join('events', 'projects.event_id', '=', 'events.id')->where(['projects.name' => 'Exhibition Stand'],['events.name' => 'KBB 2019'])->value('projects.id');
        $user_id = DB::table('users')->where('email', 'jason@formationmedia.co.uk')->value('id');

        DB::table('project_users')->insert([
            'project_id'        =>  $project_id,
            'user_id'           =>  $user_id
        ]);

        $project_id = DB::table('projects')->join('events', 'projects.event_id', '=', 'events.id')->where(['projects.name' => 'Bar Structure'],['events.name' => 'Wimbledon 2019'])->value('projects.id');
        $user_id = DB::table('users')->where('email', 'test@gmail.com')->value('id');

        DB::table('project_users')->insert([
            'project_id'        =>  $project_id,
            'user_id'           =>  $user_id
        ]);

        $project_id = DB::table('projects')->join('events', 'projects.event_id', '=', 'events.id')->where(['projects.name' => 'Exhibition Stand'],['events.name' => 'Pig & Poultry 2019'])->value('projects.id');
        $user_id = DB::table('users')->where('email', 'test2@gmail.com')->value('id');

        DB::table('project_users')->insert([
            'project_id'        =>  $project_id,
            'user_id'           =>  $user_id
        ]);
    }
}
