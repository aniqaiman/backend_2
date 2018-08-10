<?php

use Illuminate\Database\Seeder;
use App\State;

class StateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        State::create([
       	'state_name'=>'Perlis',
       	]);

       	State::create([
       	'state_name'=>'Kedah',
       	]);

       	State::create([
       	'state_name'=>'Penang',
       	]);

       	State::create([
       	'state_name'=>'Perak',
       	]);

       	State::create([
       	'state_name'=>'Kelantan',
       	]);

       	State::create([
       	'state_name'=>'Terengganu',
       	]);

       	State::create([
       	'state_name'=>'Pahang',
       	]);

       	State::create([
       	'state_name'=>'Selangor',
       	]);

       	State::create([
       	'state_name'=>'Negeri Sembilan',
       	]);

       	State::create([
       	'state_name'=>'Melaka',
       	]);

       	State::create([
       	'state_name'=>'Johor',
       	]);

       	State::create([
       	'state_name'=>'Sabah',
       	]);

       	State::create([
       	'state_name'=>'Sarawak',
       	]);

       	State::create([
       	'state_name'=>'W.P. Kuala Lumpur',
       	]);

       	State::create([
       	'state_name'=>'W.P. Putrajaya',
       	]);

       	State::create([
       	'state_name'=>'W.P. Labuan',
       	]);
    }
}
