<?php

use Illuminate\Database\Seeder;
use App\Capacity;

class CapacityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Capacity::create([
       	'capacity'=>'1 Tonne',
       	]);

       	Capacity::create([
       	'capacity'=>'2 Tonne',
       	]);

       	Capacity::create([
       	'capacity'=>'3 Tonne',
       	]);
    }
}
