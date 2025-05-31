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
                'category_name' => 'Fantasy',
                'category_abbreviation' => 'FAN',
                'description' => 'Books set in fictional universes with magic and mythical creatures.'
            ],
            [
                'category_name' => 'Science Fiction',
                'category_abbreviation' => 'SCI',
                'description' => 'Futuristic stories with advanced science and technology.'
            ],
            [
                'category_name' => 'Mystery',
                'category_abbreviation' => 'MYS',
                'description' => 'Whodunit novels full of clues, suspense, and detectives.'
            ],
        ]);
    }
}
