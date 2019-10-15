<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('project_owner_id')->unsigned()->index()->nullable();
            $table->foreign('project_owner_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('project_type_id')->unsigned()->index()->nullable();
            $table->foreign('project_type_id')->references('id')->on('project_types')->onDelete('cascade');
            $table->integer('event_id')->unsigned()->index();
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
            $table->integer('client_id')->unsigned()->index();
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->integer('client_contact_id')->unsigned()->index();
            $table->foreign('client_contact_id')->references('id')->on('client_contacts')->onDelete('cascade');
            $table->integer('venue_id')->unsigned()->index();
            $table->foreign('venue_id')->references('id')->on('venues')->onDelete('cascade');
            $table->integer('status_id')->unsigned()->index()->default(1);
            $table->foreign('status_id')->references('id')->on('project_statuses')->onDelete('cascade');
            $table->text('brief');
            $table->text('private_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
}
