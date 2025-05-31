<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('products')->insert([
            [
                'name' => 'The Hobbit',
                'category_id' => 1,
                'price' => 15.99,
                'description' => 'A hobbit\'s journey through Middle Earth in a quest to slay a dragon.'
            ],
            [
                'name' => 'Dune',
                'category_id' => 2,
                'price' => 18.50,
                'description' => 'Epic sci-fi tale of politics, prophecy, and spice on a desert planet.'
            ],
            [
                'name' => 'Sherlock Holmes: A Study in Scarlet',
                'category_id' => 3,
                'price' => 12.00,
                'description' => 'The first appearance of the brilliant detective Sherlock Holmes.'
            ],
        ]);
    }
}
