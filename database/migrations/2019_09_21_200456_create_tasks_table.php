<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id')->unsigned()->index();
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->integer('department_id')->unsigned()->index();
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
            $table->integer('task_category_id')->unsigned()->index()->nullable();
            $table->foreign('task_category_id')->references('id')->on('task_categories')->onDelete('cascade');
            $table->integer('custom_task_category_id')->unsigned()->index()->nullable();
            $table->foreign('custom_task_category_id')->references('id')->on('project_custom_task_categories')->onDelete('cascade');
            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('name');
            $table->integer('position_index');
            $table->dateTime('due_date');
            $table->dateTime('start_date');
            $table->text('notes')->nullable();
            $table->boolean('quote_required');
            $table->boolean('completed')->default('0');
            $table->dateTime('completed_date')->nullable()->default(NULL);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
