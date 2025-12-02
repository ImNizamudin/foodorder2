<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            [
                'name' => 'Indonesian',
                'slug' => 'indonesian',
                'description' => 'Traditional Indonesian cuisine with rich flavors and spices',
                'image' => null,
                'is_active' => true
            ],
            [
                'name' => 'Western',
                'slug' => 'western',
                'description' => 'Western style food including burgers, steaks, and sandwiches',
                'image' => null,
                'is_active' => true
            ],
            [
                'name' => 'Japanese',
                'slug' => 'japanese',
                'description' => 'Authentic Japanese dishes including sushi, ramen, and tempura',
                'image' => null,
                'is_active' => true
            ],
            [
                'name' => 'Chinese',
                'slug' => 'chinese',
                'description' => 'Chinese cuisine with diverse regional flavors',
                'image' => null,
                'is_active' => true
            ],
            [
                'name' => 'Desserts',
                'slug' => 'desserts',
                'description' => 'Sweet treats and desserts for every occasion',
                'image' => null,
                'is_active' => true
            ],
            [
                'name' => 'Beverages',
                'slug' => 'beverages',
                'description' => 'Refreshing drinks and beverages',
                'image' => null,
                'is_active' => true
            ],
            [
                'name' => 'Healthy',
                'slug' => 'healthy',
                'description' => 'Healthy and nutritious food options',
                'image' => null,
                'is_active' => true
            ],
            [
                'name' => 'Fast Food',
                'slug' => 'fast-food',
                'description' => 'Quick and delicious fast food options',
                'image' => null,
                'is_active' => true
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
