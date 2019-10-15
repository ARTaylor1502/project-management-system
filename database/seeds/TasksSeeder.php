<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class TasksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $project = DB::table('projects')->join('events', 'projects.event_id', '=', 'events.id')->where(['projects.name' => 'Exhibition Stand'],['events.name' => 'Crufts'])->first();

        $task_templates = DB::table('task_templates')->where('project_type_id', $project->project_type_id)->get();

        $task_templates->each(function ($template, $key) use($project, $faker) {
            DB::table('tasks')->insert([
                'project_id'        =>  $project->id,
                'department_id'     =>  $template->department_id,
                'task_category_id'  =>  $template->task_category_id,
                'user_id'           =>  1,//DB::table('users')->where('department_id', $template->department_id)->first()->id,
                'name'              =>  $template->name,
                'position_index'    =>  $key,
                'notes'             =>  $template->notes,
                'quote_required'    =>  $template->quote_required,
                'start_date'        =>  Carbon::now()->format('Y-m-d H:i:s'),
                'due_date'          =>  $faker->dateTimeBetween($startDate = 'now', date('y-m-d H:i:s', strtotime('+1 months'))),
                'created_at'        =>  Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'        =>  Carbon::now()->format('Y-m-d H:i:s')
            ]);
        });
    }
}
