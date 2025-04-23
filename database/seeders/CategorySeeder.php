<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::insert([
            ['category_name' => 'ELECTRONIC', 'category_slug' => 'ELKT'],
            ['category_name' => 'FURNITURE', 'category_slug' => 'FNTR',],
            ['category_name' => 'OFFICE STATIONARY', 'category_slug' => 'OFST',],
            ['category_name' => 'DECORATION', 'category_slug' => 'DECO',],
            ['category_name' => 'TECHNOLOGY', 'category_slug' => 'TECH',],
        ]);
    }
}
