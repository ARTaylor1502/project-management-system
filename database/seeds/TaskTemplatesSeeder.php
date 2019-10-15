<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TaskTemplatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*Schema::create('task_templates', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_type_id')->unsigned()->index();
            $table->foreign('project_type_id')->references('id')->on('project_types')->onDelete('cascade');
            $table->integer('department_id')->unsigned()->index();
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
            $table->integer('task_category_id')->unsigned()->index()->nullable();
            $table->foreign('task_category_id')->references('id')->on('task_categories')->onDelete('cascade');
            $table->integer('weeks_due_before_event_date')->nullable();
            $table->text('notes')->nullable();
            $table->string('name');
            $table->timestamps();
        });*/

        //Exhibition Stand
        $project_type_id = DB::table('project_types')->where('name', 'Exhibition Stand')->first()->id;

        //Design
        $department_id = DB::table('departments')->where('name', 'Design')->first()->id;

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'CAD Visual concept',
             'quote_required'                =>  0,
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'Artwork and Print Obtain All Client Assets',
            'quote_required'                =>  0,
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'Technical Drawing: Layout, bespoke items eg: Arches, Counters',
            'quote_required'                =>  0,
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'Electrical Plan',
            'quote_required'                =>  0,
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'Rigging Plan',
            'quote_required'                =>  0,
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'Graphics Plan',
            'quote_required'                =>  0,
        ]);


        //Event Management
        $department_id = DB::table('departments')->where('name', 'Event Management')->first()->id;

        //Stand Information
        $task_category_id = DB::table('task_categories')->where(['name' => 'Stand Information', 'department_id' => $department_id])->first()->id;

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'Size (sq m)',
            'quote_required'                =>  0,
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'Orientation',
            'quote_required'                =>  0,
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'Space only / shell scheme',
            'quote_required'                =>  0,
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'Hall plans - add to documents',
            'quote_required'                =>  0,
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'Stand number',
            'quote_required'                =>  0,
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'Panel height',
            'quote_required'                =>  0,
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'Walling',
            'quote_required'                =>  0,
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'Electrical sockets',
            'quote_required'                =>  0,
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'WiFi',
            'quote_required'                =>  0,
        ]);


        //Catering
        $task_category_id = DB::table('task_categories')->where(['name' => 'Catering', 'department_id' => $department_id])->first()->id;

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'Is catering required?',
            'quote_required'                =>  0,
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  5,
            'name'                          =>  'Catering Quote',
            'quote_required'                =>  1,
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  2,
            'name'                          =>  'Catering supplier',
            'quote_required'                =>  0,
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'Are beverages required?',
            'quote_required'                =>  1,
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  5,
            'name'                          =>  'Beverage Quote',
            'quote_required'                =>  1,
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  2,
            'name'                          =>  'Beverage supplier',
            'quote_required'                =>  0,
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'Is drayage/corkage required?',
            'quote_required'                =>  0,
        ]);


        //Client Assets/Stock
        $task_category_id = DB::table('task_categories')->where(['name' => 'Client Assets/Stock', 'department_id' => $department_id])->first()->id;

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'Client supplying items before show?',
            'quote_required'                =>  0,
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'What quantity and/or weight of items?',
            'quote_required'                =>  0,
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'Where will items return post show?',
            'quote_required'                =>  0,
        ]);


        //Venue Services
        $task_category_id = DB::table('task_categories')->where(['name' => 'Venue Services', 'department_id' => $department_id])->first()->id;

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'Electrical order',
            'quote_required'                =>  1,
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'Internet order',
            'quote_required'                =>  1,
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'Rigging points',
            'quote_required'                =>  1,
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'Piped services',
            'quote_required'                =>  1,
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'Forklift/Unloading',
            'quote_required'                =>  1,
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'Empty cases',
            'quote_required'                =>  1,
        ]);


        //Organisers & Stand Plan Submission
        $task_category_id = DB::table('task_categories')->where(['name' => 'Organisers & Stand Plan Submission', 'department_id' => $department_id])->first()->id;

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'Elevations',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'Heights',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'Top down-Plan View',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'HSE/Insurance/CPP/CMD',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'Confirmation of build',
            'quote_required'                =>  0
        ]);


        //AV Requirements
        $task_category_id = DB::table('task_categories')->where(['name' => 'AV Requirements', 'department_id' => $department_id])->first()->id;

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'Screens',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'Screens greater than 65"?',
            'quote_required'                =>  1
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'Specialist AV requirements? - SmartAV, ITR, DB Systems, Event supplier',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'iPads required?',
            'quote_required'                =>  1
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'Touchscreen',
            'quote_required'                =>  1
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'PA System',
            'quote_required'                =>  1
        ]);


        //Floral Requirements
        $task_category_id = DB::table('task_categories')->where(['name' => 'Floral Requirements', 'department_id' => $department_id])->first()->id;

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'Request - P.O.A',
            'quote_required'                =>  1
        ]);


        //Rigging Required
        $task_category_id = DB::table('task_categories')->where(['name' => 'Rigging Required', 'department_id' => $department_id])->first()->id;

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'Stock truss?',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'TFS frame? - Requires rigging eyelets',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'Bespoke? - SUS, DT Structures, Unibox, Stitch fabrics',
            'quote_required'                =>  1
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'Procurement',
            'quote_required'                =>  1
        ]);


        //Pre-ops
        $department_id = DB::table('departments')->where('name', 'Pre-Ops')->first()->id;

        //Labour
        $task_category_id = DB::table('task_categories')->where(['name' => 'Labour', 'department_id' => $department_id])->first()->id;

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'Assign Labour',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'Book Contractors',
            'quote_required'                =>  0
        ]);


        //Accommodation
        $task_category_id = DB::table('task_categories')->where(['name' => 'Accommodation', 'department_id' => $department_id])->first()->id;

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'Assign Accommodation',
            'quote_required'                =>  0
        ]);

        //Transport
        $task_category_id = DB::table('task_categories')->where(['name' => 'Transport', 'department_id' => $department_id])->first()->id;

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'Assign Transport',
            'quote_required'                =>  0
        ]);


        //Electrics
        $task_category_id = DB::table('task_categories')->where(['name' => 'Electrics', 'department_id' => $department_id])->first()->id;

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'Stocked item?',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'Specialist lighting?',
            'quote_required'                =>  1
        ]);


        //Furniture
        $task_category_id = DB::table('task_categories')->where(['name' => 'Furniture', 'department_id' => $department_id])->first()->id;

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'Request Quotation',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'Client owned?',
            'notes'                         =>  'Concept, D-Zine, Thorns, Funky Furniture, Event supplier',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'Procure furniture',
            'quote_required'                =>  0
        ]);



        //Health & Safety
        $department_id = DB::table('departments')->where('name', 'Health & Safety')->first()->id;

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'Structural engineer\'s report required - P.O.A.',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'Detailed HSE paperwork required - P.O.A.',
            'quote_required'                =>  0
        ]);


        //Production
        $department_id = DB::table('departments')->where('name', 'Production')->first()->id;

        //Flooring
        $task_category_id = DB::table('task_categories')->where(['name' => 'Flooring', 'department_id' => $department_id])->first()->id;

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'Subfloor',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'Floor covering',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'Ramps',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'Handrails',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'Flooring Height',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'Aluminium edge trim?',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'Custom flooring feature?',
            'quote_required'                =>  0
        ]);

        //Stand Structure
        $task_category_id = DB::table('task_categories')->where(['name' => 'Stand Structure', 'department_id' => $department_id])->first()->id;

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'Walling height',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'Walling finish ',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'Bespoke items',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'Storeroom',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'If storeroom is required, does it require vision port and code lock? ',
            'quote_required'                =>  0
        ]);

        //Stand Furniture
        $task_category_id = DB::table('task_categories')->where(['name' => 'Stand Furniture', 'department_id' => $department_id])->first()->id;

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'Custom counters',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'Stock counters',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'Counter finishes',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'Custom displays',
            'quote_required'                =>  0
        ]);


        //Graphical Elements
        $task_category_id = DB::table('task_categories')->where(['name' => 'Graphical Elements', 'department_id' => $department_id])->first()->id;

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'Single use or reusable',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'Vinyl',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'Canvas',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'Aluminium composite',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'Foamex',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'Custom Requirement - 3rd party',
            'quote_required'                =>  0
        ]);


        //Post-Ops
        $department_id = DB::table('departments')->where('name', 'Post-Ops')->first()->id;

        //Storage
        $task_category_id = DB::table('task_categories')->where(['name' => 'Storage', 'department_id' => $department_id])->first()->id;

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'Any items need to be stored post event?',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'Any items need to be delivered back to offices',
            'quote_required'                =>  1
        ]);



        //Outdoor Exhibition Stand
        $project_type_id = DB::table('project_types')->where('name', 'Outdoor Exhibition Stand')->first()->id;

        //Design
        $department_id = DB::table('departments')->where('name', 'Design')->first()->id;

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'CAD Visual concept',
            'quote_required'                =>  0,
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'weeks_due_before_event_date'   =>  2,
            'name'                          =>  'Artwork',
            'quote_required'                =>  0,
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'Technical Drawing',
            'quote_required'                =>  0,
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'weeks_due_before_event_date'   =>  2,
            'name'                          =>  'Electrical Plan',
            'quote_required'                =>  0,
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'weeks_due_before_event_date'   =>  3,
            'name'                          =>  'Rigging Plan',
            'quote_required'                =>  0,
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'weeks_due_before_event_date'   =>  2,
            'name'                          =>  'Ballast Plan',
            'quote_required'                =>  0,
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'weeks_due_before_event_date'   =>  4,
            'name'                          =>  'Panel Plan',
            'quote_required'                =>  0,
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'weeks_due_before_event_date'   =>  2,
            'name'                          =>  'Graphics Plan',
            'quote_required'                =>  0,
        ]);


        //Design
        $department_id = DB::table('departments')->where('name', 'Event Management')->first()->id;

        //Stand Information
        $task_category_id = DB::table('task_categories')->where(['name' => 'Stand Information', 'department_id' => $department_id])->first()->id;

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  4,
            'name'                          =>  'Size (sq m)',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  4,
            'name'                          =>  'Site Map / Trade Stand Plan',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  4,
            'name'                          =>  'Space Only',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  4,
            'notes'                         =>  'When will the temporary structure be finished etc',
            'name'                          =>  'Tentage Tenancy',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'notes'                         =>  'Size, Location, Plans, Flooring & Supplier',
            'weeks_due_before_event_date'   =>  4,
            'name'                          =>  'Tent/Marquee',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'notes'                         =>  'Wind Calculations / Overturning Factors',
            'weeks_due_before_event_date'   =>  4,
            'name'                          =>  'Ballast and Counterweight requirements  for wind stability of structures, signage and walling',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'notes'                         =>  'Point Loading / Venue Surface',
            'weeks_due_before_event_date'   =>  4,
            'name'                          =>  'Location Info, Surface and Levels',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'notes'                         =>  'Underground & Overhead Mains Services (i.e. Power Cables)',
            'weeks_due_before_event_date'   =>  4,
            'name'                          =>  'Service Plan for Location',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'notes'                         =>  'Fork lifts, Cherry Pickers, Lift Platforms, Scaffolding Towers',
            'weeks_due_before_event_date'   =>  4,
            'name'                          =>  'Plant Machinery Required',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'notes'                         =>  'Grass, Tarmac, Paving, Decking. (Point Loading)',
            'weeks_due_before_event_date'   =>  4,
            'name'                          =>  'Ground Condition',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  4,
            'name'                          =>  'Orientation',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  2,
            'name'                          =>  'Stand Number',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  4,
            'name'                          =>  'Height of Structure and/or Activation',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'notes'                         =>  'Residential Working Hours / City Centre Locations',
            'weeks_due_before_event_date'   =>  4,
            'name'                          =>  'Venue Restrictions',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  4,
            'name'                          =>  'Location Build / Breakdown Parameters',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'notes'                         =>  'Structural Sign-off from Engineer at Location',
            'weeks_due_before_event_date'   =>  4,
            'name'                          =>  'Structural Sign-Off',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'notes'                         =>  'Detailed H&S requirements, adverse weather plans, fire risk assessments, wind management plans',
            'weeks_due_before_event_date'   =>  4,
            'name'                          =>  'SHealth & Safety',
            'quote_required'                =>  0
        ]);



        //Catering
        $task_category_id = DB::table('task_categories')->where(['name' => 'Catering', 'department_id' => $department_id])->first()->id;

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'Is catering required?',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'Is catering required?',
            'quote_required'                =>  1
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'Catering Quote',
            'quote_required'                =>  1
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'Catering supplier',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'Are beverages required?',
            'quote_required'                =>  1
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'Beverage Quote',
            'quote_required'                =>  1
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'Beverage supplier',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'Is drayage required?',
            'quote_required'                =>  0
        ]);


        //Client Assets/Stock
        $task_category_id = DB::table('task_categories')->where(['name' => 'Client Assets/Stock', 'department_id' => $department_id])->first()->id;

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  1,
            'notes'                         =>  'Date being delivered to HF. Date being collected from HF',
            'name'                          =>  'Client supplying items before show?',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  1,
            'name'                          =>  'What quantity and/or weight of items?',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  1,
            'notes'                         =>  'Stock check required?',
            'name'                          =>  'Will items return post show?',
            'quote_required'                =>  0
        ]);


        //Client Assets/Stock
        $task_category_id = DB::table('task_categories')->where(['name' => 'Venue Services', 'department_id' => $department_id])->first()->id;

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  4,
            'notes'                         =>  'Before event deadline date. Other wise charges are incurred',
            'name'                          =>  'Electrical order',
            'quote_required'                =>  1
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  4,
            'notes'                         =>  'Before event deadline date. Other wise charges are incurred',
            'name'                          =>  'Generator Required?',
            'quote_required'                =>  1
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  4,
            'notes'                         =>  'Before event deadline date. Other wise charges are incurred',
            'name'                          =>  'Internet order',
            'quote_required'                =>  1
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  4,
            'notes'                         =>  'Before event deadline date. Other wise charges are incurred',
            'name'                          =>  'Piped services',
            'quote_required'                =>  1
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  4,
            'notes'                         =>  'Before event deadline date. Other wise charges are incurred',
            'name'                          =>  'Rigging points',
            'quote_required'                =>  1
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  4,
            'notes'                         =>  'Before event deadline date. Other wise charges are incurred',
            'name'                          =>  'Forklift/Unloading',
            'quote_required'                =>  1
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  4,
            'notes'                         =>  'Before event deadline date. Other wise charges are incurred',
            'name'                          =>  'Empty cases',
            'quote_required'                =>  1
        ]);


        //Organisers & Stand Plan Submission
        $task_category_id = DB::table('task_categories')->where(['name' => 'Organisers & Stand Plan Submission', 'department_id' => $department_id])->first()->id;

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'Elevations',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'Heights',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'Top down',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'HSE/Insurance',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'Structural Calculations',
            'quote_required'                =>  0
        ]);



        //AV Requirements
        $task_category_id = DB::table('task_categories')->where(['name' => 'AV Requirements', 'department_id' => $department_id])->first()->id;

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'Screens',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  4,
            'notes'                         =>  '3rd party',
            'name'                          =>  'Screens greater than 65"?',
            'quote_required'                =>  1
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  3,
            'notes'                         =>  'SmartAV, ITR, DB Systems, Event supplier',
            'name'                          =>  'Specialist AV requirements?',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  3,
            'name'                          =>  'iPads required?',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  3,
            'name'                          =>  'Touchscreen',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  3,
            'name'                          =>  'PA System',
            'quote_required'                =>  0
        ]);


        //Floral Requirements
        $task_category_id = DB::table('task_categories')->where(['name' => 'Floral Requirements', 'department_id' => $department_id])->first()->id;

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  4,
            'notes'                         =>  'P.O.A',
            'name'                          =>  'Request',
            'quote_required'                =>  1
        ]);


        //Rigging Required
        $task_category_id = DB::table('task_categories')->where(['name' => 'Rigging Required', 'department_id' => $department_id])->first()->id;

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  3,
            'notes'                         =>  'Must be aware that bespoke items can take longer for delivery',
            'name'                          =>  'Stock truss?',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  3,
            'notes'                         =>  'HF stock or purchased',
            'name'                          =>  'TFS frame? - Requires rigging eyelets',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  4,
            'notes'                         =>  'SUS, DT Structures, Unibox, Stitch fabrics',
            'name'                          =>  'Bespoke?',
            'quote_required'                =>  1
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  4,
            'name'                          =>  'Procurement',
            'quote_required'                =>  1
        ]);


        //Pre-Ops
        $department_id = DB::table('departments')->where('name', 'Pre-Ops')->first()->id;

        //Labour
        $task_category_id = DB::table('task_categories')->where(['name' => 'Labour', 'department_id' => $department_id])->first()->id;

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'Assign Labour',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  12,
            'notes'                         =>  'Booking contractors with as much notice as possible. Some annually',
            'name'                          =>  'Specialist Labour',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  4,
            'notes'                         =>  'List of Contractors - Refer to subcontract list',
            'name'                          =>  'Book Contractors',
            'quote_required'                =>  0
        ]);


        //Accommodation
        $task_category_id = DB::table('task_categories')->where(['name' => 'Accommodation', 'department_id' => $department_id])->first()->id;

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  6,
            'notes'                         =>  'Booking as early as possible, annually. Making sure hotels have adequate parking for vans/lorries/Trailers',
            'name'                          =>  'Assign Accommodation',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  6,
            'notes'                         =>  'Premier Inn, Travel lodge, Booking.com and Holiday Inn',
            'name'                          =>  'Book accommodation',
            'quote_required'                =>  0
        ]);


        //Transport
        $task_category_id = DB::table('task_categories')->where(['name' => 'Transport', 'department_id' => $department_id])->first()->id;

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  4,
            'notes'                         =>  'Different types - Subcontract drivers, subcontract driver with van/7.5 ton',
            'name'                          =>  'Assign Transport',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  4,
            'notes'                         =>  'Gain one off quotes',
            'name'                          =>  'Book Subcontractor Drivers/Vehicles',
            'quote_required'                =>  0
        ]);


        //Electrics
        $task_category_id = DB::table('task_categories')->where(['name' => 'Electrics', 'department_id' => $department_id])->first()->id;

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  2,
            'name'                          =>  'Stocked item?',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  2,
            'name'                          =>  'Suitable Outdoor Power Distro?',
            'quote_required'                =>  1
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  2,
            'name'                          =>  'Specialist lighting?',
            'quote_required'                =>  1
        ]);


        //Furniture
        $task_category_id = DB::table('task_categories')->where(['name' => 'Furniture', 'department_id' => $department_id])->first()->id;

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  2,
            'notes'                         =>  'Concept, D-Zine, Thorns, Funky Furniture, Event supplier. Deadline date set if being delivered to HF min 24hrs before leaving',
            'name'                          =>  'Request Quotation ',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  2,
            'name'                          =>  'Client owned?',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  2,
            'name'                          =>  'Procure furniture',
            'quote_required'                =>  0
        ]);

        //Health & Safety
        $department_id = DB::table('departments')->where('name', 'Health & Safety')->first()->id;

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'weeks_due_before_event_date'   =>  2,
            'notes'                         =>  'P.O.A',
            'name'                          =>  'Structural Engineer\'s report required',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'weeks_due_before_event_date'   =>  2,
            'notes'                         =>  'P.O.A',
            'name'                          =>  'Electrical Sign-Off On-Site',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'weeks_due_before_event_date'   =>  2,
            'notes'                         =>  'P.O.A',
            'name'                          =>  'Structural Sign-Off On-Site',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'weeks_due_before_event_date'   =>  2,
            'notes'                         =>  'P.O.A',
            'name'                          =>  'Detailed HSE paperwork required',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'weeks_due_before_event_date'   =>  2,
            'notes'                         =>  'Barriers, Site Signage, 3-Point PPE, Fire Marshall etc',
            'name'                          =>  'Operating under CDM?',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'weeks_due_before_event_date'   =>  2,
            'notes'                         =>  'Written confirmation from client?',
            'name'                          =>  'Have Henson Franklyn been appointed Principal Contractor?',
            'quote_required'                =>  0
        ]);



        //Production
        $department_id = DB::table('departments')->where('name', 'Production')->first()->id;

        //Print
        $task_category_id = DB::table('task_categories')->where(['name' => 'Print', 'department_id' => $department_id])->first()->id;

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  2,
            'name'                          =>  'Internal',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  2,
            'notes'                         =>  'All Large canvass printing to have a minimum deadline of 5 working days before leaving HF. If being delivered direct to Venue a dedicated courier must be used',
            'name'                          =>  'External',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  2,
            'notes'                         =>  'House of flags',
            'name'                          =>  'Flags',
            'quote_required'                =>  0
        ]);


        //Fabrication
        $task_category_id = DB::table('task_categories')->where(['name' => 'Fabrication', 'department_id' => $department_id])->first()->id;

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  6,
            'name'                          =>  'Internal',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  6,
            'notes'                         =>  'Suppliers Matty/Owen, Lee lloyd, Formatix, MGM Exhibitions, RH Displays,RB Joinery. Delivered to HF/Venue or requires collection',
            'name'                          =>  'External',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  4,
            'notes'                         =>  'Steve Hurst',
            'name'                          =>  'Metal Fabrication',
            'quote_required'                =>  0
        ]);


        //Flooring
        $task_category_id = DB::table('task_categories')->where(['name' => 'Flooring', 'department_id' => $department_id])->first()->id;

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  4,
            'notes'                         =>  'Eco-floor, bespoke, stage flooring',
            'name'                          =>  'Subfloor',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  3,
            'notes'                         =>  'Eco-floor, bespoke, stage flooring',
            'name'                          =>  'Suppliers - Reeds, Croft Carpets',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  3,
            'name'                          =>  'Ramps',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  3,
            'name'                          =>  'Handrails',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  3,
            'name'                          =>  'Flooring Height',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  3,
            'notes'                         =>  'Stock item or needs procuring',
            'name'                          =>  'Non-Slip Edge Trim',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  3,
            'notes'                         =>  'Stock item or needs procuring',
            'name'                          =>  'Aluminium edge trim?',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  3,
            'name'                          =>  'Non-Slip Floor Covering',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  4,
            'notes'                         =>  'Installation - Reeds, Brownlows',
            'name'                          =>  'Custom flooring feature?',
            'quote_required'                =>  0
        ]);


        //Stand Structure
        $task_category_id = DB::table('task_categories')->where(['name' => 'Stand Structure ', 'department_id' => $department_id])->first()->id;

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  4,
            'name'                          =>  'Walling height',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  4,
            'notes'                         =>  'Paint/Foamback/Canvass/maxilte',
            'name'                          =>  'Walling finish',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  4,
            'notes'                         =>  'Fabrics/ maxilte/',
            'name'                          =>  'Bespoke items',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  4,
            'name'                          =>  'Storeroom',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  4,
            'notes'                         =>  'Stock panels - 2.2m/2.3m/2.4m/2.7m/3m',
            'name'                          =>  'Stock Panels and/or Bespoke Panels',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  4,
            'name'                          =>  'Moisture Resident MDF for External Facing Panels',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  2,
            'name'                          =>  'Internal Wall Ballast',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  2,
            'notes'                         =>  '2"x2" Timber/ 1.5 inch aluminum trim',
            'name'                          =>  'Wall Bracing',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  6,
            'notes'                         =>  '6 weeks Depending on availability of in internal/external manufacturers.',
            'name'                          =>  'Be-Spoke Structure?',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  4,
            'name'                          =>  'Quadlight Sub-Structure?',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  4,
            'name'                          =>  'If storeroom is required, does it require vision port and code lock?',
            'quote_required'                =>  0
        ]);


        //Stand Furniture
        $task_category_id = DB::table('task_categories')->where(['name' => 'Stand Furniture', 'department_id' => $department_id])->first()->id;

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  4,
            'notes'                         =>  'Hardwood Skids (Discuss Finishes)',
            'name'                          =>  'Custom counters',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  2,
            'name'                          =>  'Stock counters',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  2,
            'notes'                         =>  'Paint/Laminate/Vinyl wrap',
            'name'                          =>  'Counter finishes',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  2,
            'notes'                         =>  'Finish required',
            'name'                          =>  'Custom displays',
            'quote_required'                =>  0
        ]);


        //Graphical Elements
        $task_category_id = DB::table('task_categories')->where(['name' => 'Graphical Elements', 'department_id' => $department_id])->first()->id;

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  2,
            'name'                          =>  'Single use or reusable',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  2,
            'notes'                         =>  'High Tac / Non-Slip Floor Graphics - Ensure correct vinyl is used for application',
            'name'                          =>  'Vinyl',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  2,
            'notes'                         =>  'Upto 3.2m / Block Out / Standard?',
            'name'                          =>  'Canvas',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  2,
            'notes'                         =>  '25mm Centres for Stand Off Graphics. 3mm Thick',
            'name'                          =>  'Aluminium composite',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  2,
            'notes'                         =>  '3mm,5mm,8mm and 10mm thick',
            'name'                          =>  'Foamex',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  3,
            'notes'                         =>  '3rd party	3 weeks	Trent plastics and Pyramid',
            'name'                          =>  'Custom Requirement',
            'quote_required'                =>  0
        ]);

        //Post-Ops
        $department_id = DB::table('departments')->where('name', 'Post-Ops')->first()->id;

        //Storage
        $task_category_id = DB::table('task_categories')->where(['name' => 'Storage', 'department_id' => $department_id])->first()->id;

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  3,
            'notes'                         =>  'Date delivered to HF',
            'name'                          =>  'Any items need to be stored post event?',
            'quote_required'                =>  0
        ]);

        DB::table('task_templates')->insert([
            'project_type_id'               =>  $project_type_id,
            'department_id'                 =>  $department_id,
            'task_category_id'              =>  $task_category_id,
            'weeks_due_before_event_date'   =>  3,
            'name'                          =>  'Any items need to be delivered back to offices',
            'quote_required'                =>  1
        ]);
    }
}
