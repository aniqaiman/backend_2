<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddQuantitiesToWastagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wastages', function (Blueprint $table) {
            //
            $table->integer('promo_wastage');
            $table->integer('storage_wastage');
            $table->decimal('buy_at_price',8,2
        );
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wastages', function (Blueprint $table) {
            //
        });
    }
}
