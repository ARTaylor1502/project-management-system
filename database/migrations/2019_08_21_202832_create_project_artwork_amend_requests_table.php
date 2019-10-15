<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectArtworkAmendRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_artwork_amend_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('internal_requester_id')->unsigned()->index()->nullable();
            $table->foreign('internal_requester_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('client_requester_id')->unsigned()->index()->nullable();
            $table->foreign('client_requester_id')->references('id')->on('client_users')->onDelete('cascade');
            $table->integer('artwork_id')->unsigned()->index()->nullable();
            $table->foreign('artwork_id')->references('id')->on('project_artwork')->onDelete('cascade');
            $table->text('description');
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
        Schema::dropIfExists('project_artwork_amend_requests');
    }
}
