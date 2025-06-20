<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('product_categories')->insert([
            [
                'category_name' => 'Coffee',
                'category_abbreviation' => 'COF',
                'description' => 'Freshly brewed hot and iced coffee beverages.'
            ],
            [
                'category_name' => 'Tea',
                'category_abbreviation' => 'TEA',
                'description' => 'Wide selection of teas including black, green, and herbal.'
            ],
            [
                'category_name' => 'Pastries',
                'category_abbreviation' => 'PAS',
                'description' => 'Freshly baked pastries and sweet treats.'
            ],
            [
                'category_name' => 'Sandwiches',
                'category_abbreviation' => 'SND',
                'description' => 'Delicious sandwiches with fresh ingredients.'
            ],
            [
                'category_name' => 'Smoothies',
                'category_abbreviation' => 'SMO',
                'description' => 'Refreshing fruit and vegetable smoothies.'
            ],
        ]);
    }
}
