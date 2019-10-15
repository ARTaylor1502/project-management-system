<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaskCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Event Management
        DB::table('task_categories')->insert([
            'department_id'         =>  DB::table('departments')->where('name', 'Event Management')->first()->id,
            'name'                  =>  'General'
        ]);

        DB::table('task_categories')->insert([
            'department_id'      =>  DB::table('departments')->where('name', 'Event Management')->first()->id,
            'name'                  =>  'Stand Information'
        ]);

        DB::table('task_categories')->insert([
            'department_id'      =>  DB::table('departments')->where('name', 'Event Management')->first()->id,
            'name'                  =>  'Catering'
        ]);

        DB::table('task_categories')->insert([
            'department_id'      =>  DB::table('departments')->where('name', 'Event Management')->first()->id,
            'name'                  =>  'Venue Services'
        ]);

        DB::table('task_categories')->insert([
            'department_id'      =>  DB::table('departments')->where('name', 'Event Management')->first()->id,
            'name'                  =>  'Organisers & Stand Plan Submission'
        ]);

        DB::table('task_categories')->insert([
            'department_id'      =>  DB::table('departments')->where('name', 'Event Management')->first()->id,
            'name'                  =>  'Floral Requirements'
        ]);

        DB::table('task_categories')->insert([
            'department_id'      =>  DB::table('departments')->where('name', 'Event Management')->first()->id,
            'name'                  =>  'Site Survey'
        ]);

        DB::table('task_categories')->insert([
            'department_id'      =>  DB::table('departments')->where('name', 'Event Management')->first()->id,
            'name'                  =>  'Client Assets/Stock'
        ]);

        DB::table('task_categories')->insert([
            'department_id'      =>  DB::table('departments')->where('name', 'Event Management')->first()->id,
            'name'                  =>  'Digital/Engagement'
        ]);

        DB::table('task_categories')->insert([
            'department_id'      =>  DB::table('departments')->where('name', 'Event Management')->first()->id,
            'name'                  =>  'AV Requirements'
        ]);

        DB::table('task_categories')->insert([
            'department_id'      =>  DB::table('departments')->where('name', 'Event Management')->first()->id,
            'name'                  =>  'Rigging Required'
        ]);

        //Pre-ops
        DB::table('task_categories')->insert([
            'department_id'      =>  DB::table('departments')->where('name', 'Pre-ops')->first()->id,
            'name'                  =>  'Labour'
        ]);

        DB::table('task_categories')->insert([
            'department_id'      =>  DB::table('departments')->where('name', 'Pre-ops')->first()->id,
            'name'                  =>  'Accommodation'
        ]);

        DB::table('task_categories')->insert([
            'department_id'      =>  DB::table('departments')->where('name', 'Pre-ops')->first()->id,
            'name'                  =>  'Transport'
        ]);

        DB::table('task_categories')->insert([
            'department_id'      =>  DB::table('departments')->where('name', 'Pre-ops')->first()->id,
            'name'                  =>  'Electrics'
        ]);

        DB::table('task_categories')->insert([
            'department_id'      =>  DB::table('departments')->where('name', 'Pre-ops')->first()->id,
            'name'                  =>  'Procurement'
        ]);

        DB::table('task_categories')->insert([
            'department_id'      =>  DB::table('departments')->where('name', 'Pre-ops')->first()->id,
            'name'                  =>  'Furniture'
        ]);

        //Production
        DB::table('task_categories')->insert([
            'department_id'      =>  DB::table('departments')->where('name', 'Production')->first()->id,
            'name'                  =>  'Print'
        ]);

        DB::table('task_categories')->insert([
            'department_id'      =>  DB::table('departments')->where('name', 'Production')->first()->id,
            'name'                  =>  'Fabrication'
        ]);

        DB::table('task_categories')->insert([
            'department_id'      =>  DB::table('departments')->where('name', 'Production')->first()->id,
            'name'                  =>  'Flooring'
        ]);

        DB::table('task_categories')->insert([
            'department_id'      =>  DB::table('departments')->where('name', 'Production')->first()->id,
            'name'                  =>  'Stand Structure'
        ]);

        DB::table('task_categories')->insert([
            'department_id'      =>  DB::table('departments')->where('name', 'Production')->first()->id,
            'name'                  =>  'Stand Furniture'
        ]);

        DB::table('task_categories')->insert([
            'department_id'      =>  DB::table('departments')->where('name', 'Production')->first()->id,
            'name'                  =>  'Electrics'
        ]);

        DB::table('task_categories')->insert([
            'department_id'      =>  DB::table('departments')->where('name', 'Production')->first()->id,
            'name'                  =>  'Plumbing'
        ]);

        DB::table('task_categories')->insert([
            'department_id'      =>  DB::table('departments')->where('name', 'Production')->first()->id,
            'name'                  =>  'Internet'
        ]);

        DB::table('task_categories')->insert([
            'department_id'      =>  DB::table('departments')->where('name', 'Production')->first()->id,
            'name'                  =>  'Graphical Elements'
        ]);

        //Post-ops
        DB::table('task_categories')->insert([
            'department_id'      =>  DB::table('departments')->where('name', 'Post-ops')->first()->id,
            'name'                  =>  'Storage'
        ]);
    }
}
