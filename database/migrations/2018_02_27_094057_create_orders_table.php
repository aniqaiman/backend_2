<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('orders', function(Blueprint $table){
            $table->increments('order_id');
            $table->string('user_id');
            $table->string('product_id');
            $table->string('item_quantity');
            $table->string('product_price');
            $table->string('promo_price');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExist('orders');
    }
}
