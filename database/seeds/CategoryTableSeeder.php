<?php

use Illuminate\Database\Seeder;
use App\Category;

class CategoryTableSeeder extends Seeder
{
    public function run()
    {
        Category::create([
       	'cat_name'=>'Fruit',
       	]);

       	Category::create([
       	'cat_name'=>'Vegetable',
       	]);
    }
}
