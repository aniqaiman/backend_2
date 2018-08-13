<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function(Blueprint $table){
            $table->increments('product_id');
            $table->string('product_name');
            $table->longtext('product_desc');
            $table->string('price_id');
            $table->string('product_image');
            $table->string('category');
            $table->string('quantity');
            $table->longtext('short_desc');
            // $table->string('price_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExist('products');
    }
}
