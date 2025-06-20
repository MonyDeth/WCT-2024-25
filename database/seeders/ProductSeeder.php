<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
    DB::table('products')->insert([
    // Coffee
    [
        'name' => 'Espresso',
        'category_id' => 1,
        'price' => 2.50,
        'description' => 'Strong, rich espresso shot made from freshly ground beans.'
    ],
    [
        'name' => 'Cappuccino',
        'category_id' => 1,
        'price' => 3.75,
        'description' => 'Espresso topped with steamed milk foam.'
    ],
    [
        'name' => 'Latte',
        'category_id' => 1,
        'price' => 4.00,
        'description' => 'Smooth espresso with steamed milk and a light layer of foam.'
    ],
    [
        'name' => 'Americano',
        'category_id' => 1,
        'price' => 3.00,
        'description' => 'Espresso diluted with hot water for a rich black coffee.'
    ],

    // Tea
    [
        'name' => 'Matcha Green Tea',
        'category_id' => 2,
        'price' => 3.50,
        'description' => 'Spiced black tea mixed with steamed milk.'
    ],
    [
        'name' => 'Matcha Latte',
        'category_id' => 2,
        'price' => 4.00,
        'description' => 'Traditional Japanese powdered green tea with a smooth finish.'
    ],
    [
        'name' => 'Iced Lemon Tea',
        'category_id' => 2,
        'price' => 3.50,
        'description' => 'Refreshing cold black tea with a splash of lemon.'
    ],

    // Pastries
    [
        'name' => 'Croissant',
        'category_id' => 3,
        'price' => 2.75,
        'description' => 'Flaky, buttery French pastry, perfect for breakfast.'
    ],
    [
        'name' => 'Blueberry Muffin',
        'category_id' => 3,
        'price' => 3.00,
        'description' => 'Moist muffin packed with fresh blueberries.'
    ],
    [
        'name' => 'Chocolate Chip Cookie',
        'category_id' => 3,
        'price' => 1.50,
        'description' => 'Classic cookie loaded with chocolate chips.'
    ],

    // Sandwiches
    [
        'name' => 'Turkey Sandwich',
        'category_id' => 4,
        'price' => 7.50,
        'description' => 'Sliced turkey breast with lettuce, tomato, and mayo on whole wheat.'
    ],
    [
        'name' => 'Chicken Salad Sandwich',
        'category_id' => 4,
        'price' => 7.00,
        'description' => 'Creamy chicken salad on fresh bread.'
    ],
    [
        'name' => 'BLT Sandwich',
        'category_id' => 4,
        'price' => 7.25,
        'description' => 'Bacon, lettuce, and tomato with mayo on toasted bread.'
    ],

    // Smoothies
    [
        'name' => 'Strawberry Banana Smoothie',
        'category_id' => 5,
        'price' => 5.00,
        'description' => 'Blend of fresh strawberries, bananas, and yogurt.'
    ],
]);

    }
}
