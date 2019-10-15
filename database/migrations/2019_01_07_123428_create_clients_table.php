<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('landline_tele');
            $table->string('mobile_number')->nullable();
            $table->string('company_colour');
            $table->string('website');
            $table->integer('account_manager_id')->unsigned()->index()->nullable();
            $table->foreign('account_manager_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('client_type_id')->unsigned()->index()->nullable();
            $table->foreign('client_type_id')->references('id')->on('client_types')->onDelete('cascade');
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
        Schema::dropIfExists('clients');
    }
}
