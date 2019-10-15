<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVenuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('venues', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('address_first_line');
            $table->string('address_second_line')->nullable();
            $table->string('address_town');
            $table->string('address_county')->nullable();
            $table->string('address_postcode');
            $table->string('what3words_code');
            $table->string('landline_tele')->nullable();
            $table->integer('car_park_type_id')->unsigned()->index()->nullable();
            $table->foreign('car_park_type_id')->references('id')->on('car_park_types')->onDelete('cascade');
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
        Schema::dropIfExists('venues');
    }
}
