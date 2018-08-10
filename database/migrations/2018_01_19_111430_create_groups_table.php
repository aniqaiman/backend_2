<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupsTable extends Migration
{
    public function up()
    {
        Schema::create('groups', function(Blueprint $table){
            $table->tinyIncrements('id');
            $table->string('name');
        });
    }

    public function down()
    {
        Schema::dropIfExist('groups');
    }
}
