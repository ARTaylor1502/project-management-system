<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaskTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_templates', function (Blueprint $table) {
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
            $table->boolean('quote_required');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('task_templates');
    }
}
