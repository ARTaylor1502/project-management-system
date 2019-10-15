<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectArtworkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_artwork', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id')->unsigned()->index()->nullable();
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->integer('creator_id')->unsigned()->index();
            $table->foreign('creator_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('artwork_type_id')->unsigned()->index();
            $table->foreign('artwork_type_id')->references('id')->on('artwork_types')->onDelete('cascade');
            $table->string('artwork_url')->nullable();
            $table->string('name');
            $table->string('material')->nullable();
            $table->string('print_code')->nullable();
            $table->integer('width')->nullable();
            $table->integer('height')->nullable();
            $table->integer('depth')->nullable();
            $table->text('description');
            $table->string('what3words_code')->nullable();
            $table->boolean('internally_approved')->default(false);
            $table->integer('internal_approver_id')->unsigned()->index()->nullable();
            $table->foreign('internal_approver_id')->references('id')->on('users')->onDelete('cascade');
            $table->dateTime('internally_approved_at')->nullable();
            $table->boolean('client_approved')->default(false);
            $table->integer('client_approver_id')->unsigned()->index()->nullable();
            $table->foreign('client_approver_id')->references('id')->on('users')->onDelete('cascade');
            $table->dateTime('client_approved_at')->nullable();
            $table->boolean('ready_to_print')->default(false);
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
        Schema::dropIfExists('project_artwork');
    }
}
