<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) 
        {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('email');
            $table->string('password')->nullable(false);
            $table->longtext('address')->nullable(false);
            $table->string('phone_number');
            $table->string('mobile_number');
            $table->string('display_picture');
            $table->string('company_name');
            $table->string('company_registration_mykad_number');
            $table->string('bussiness_hour');
            $table->string('bank_name');
            $table->string('bank_account_holder_name');
            $table->string('bank_account_number');
            $table->string('latitude');
            $table->string('longitude');
            $table->string('driver_license_number');
            $table->string('driver_license_picture');
            $table->string('lorry_roadtax_expiry');
            $table->unsignedTinyInteger('lorry_type_id');
            $table->unsignedTinyInteger('lorry_capacity_id');
            $table->string('lorry_plate_number');
            $table->unsignedTinyInteger('state_id');
            $table->unsignedTinyInteger('group_id')->nullable(false);
            $table->boolean('status_email')->nullable(false)->default(false);
            $table->boolean('status_account')->nullable(false)->default(false);
            $table->rememberToken();
            $table->timestamps();
        });    
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
