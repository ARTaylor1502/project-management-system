<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')->unsigned()->index();
            $table->foreign('category_id')->references('id')->on('product_categories')->onDelete('cascade');
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('private_notes')->nullable();
            $table->integer('quantity_available');
            $table->integer('quantity_total');
            $table->decimal('cost', 10, 2);
            $table->integer('cost_type_id')->unsigned()->index();
            $table->foreign('cost_type_id')->references('id')->on('cost_types')->onDelete('cascade');
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
        Schema::dropIfExists('products');
    }
}
