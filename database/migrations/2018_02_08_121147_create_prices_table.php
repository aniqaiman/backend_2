<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePricesTable extends Migration
{
    public function up()
    {
        Schema::create('prices', function(Blueprint $table){
            $table->increments('price_id');
            $table->string('product_id');
            $table->string('product_price');
            $table->string('product_price2');
            $table->string('product_price3');
            $table->date('date_price');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExist('prices');
    }
}
