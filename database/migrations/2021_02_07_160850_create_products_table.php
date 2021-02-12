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
            $table->string('name');
            $table->unsignedInteger('category_id');
            $table->integer('total_rating')->default('0');
            $table->integer('total_vote')->default('0');
            $table->text('image')->nullable();
            $table->decimal('price', 15, 2)->unsigned();
            $table->decimal('weight', 20, 2)->unsigned();
            $table->text('description')->nullable();
            $table->integer('created_by')->unsigned()->comment('user id');
            $table->integer('updated_by')->unsigned()->comment('user id');
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
