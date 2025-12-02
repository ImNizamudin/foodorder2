<?php

namespace Database\Seeders;

use App\Models\MenuItem;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class RestaurantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get or create an owner user
        // $owner = User::where('email', 'owner@foodorder.com')->first();

        // if (!$owner) {
        //     $owner = User::create([
        //         'name' => 'Restaurant Owner',
        //         'email' => 'owner@foodorder.com',
        //         'password' => bcrypt('password'),
        //         'role' => 'owner',
        //         'phone' => '081234567891',
        //     ]);
        // }

        $restaurants = [
            [
                'name' => 'Warung Enak',
                'description' => 'Authentic Indonesian cuisine with traditional recipes passed down through generations. Our dishes are made with fresh ingredients and authentic spices.',
                'address' => 'Jl. Sudirman No. 123, Jakarta Pusat',
                'phone' => '+622157890123',
                'email' => 'info@warungenak.com',
                'logo' => null,
                'cover_image' => null,
                'status' => 'active',
                'user_id' => User::where('email', 'budi@warungenak.com')->first()->id
            ],
            [
                'name' => 'Sushi Master',
                'description' => 'Premium Japanese restaurant specializing in authentic sushi, sashimi, and traditional Japanese dishes. Our chefs are trained in Tokyo.',
                'address' => 'Plaza Senayan Lt. 3, Jakarta Selatan',
                'phone' => '+622157890124',
                'email' => 'reservation@sushimaster.com',
                'logo' => null,
                'cover_image' => null,
                'status' => 'active',
                'user_id' => User::where('email', 'sari@sushimaster.com')->first()->id
            ],
            [
                'name' => 'Burger Kingdom',
                'description' => 'Home of the most delicious burgers in town! We use 100% premium beef and fresh ingredients to create the perfect burger experience.',
                'address' => 'Jl. Thamrin No. 45, Jakarta Pusat',
                'phone' => '+622157890125',
                'email' => 'order@burgerkingdom.com',
                'logo' => null,
                'cover_image' => null,
                'status' => 'active',
                'user_id' => User::where('email', 'andi@burgerkingdom.com')->first()->id
            ],
            [
                'name' => 'Noodle House',
                'description' => 'Specializing in authentic Chinese noodles and dim sum. Our handmade noodles and traditional recipes will transport you to the streets of Beijing.',
                'address' => 'Pondok Indah Mall Lt. 2, Jakarta Selatan',
                'phone' => '+622157890126',
                'email' => 'hello@noodlehouse.com',
                'logo' => null,
                'cover_image' => null,
                'status' => 'active',
                'user_id' => User::where('email', 'lisa@noodlehouse.com')->first()->id
            ],
            [
                'name' => 'Sweet Dreams Desserts',
                'description' => 'Your favorite dessert paradise! From artisanal cakes to traditional sweets, we have everything to satisfy your sweet tooth.',
                'address' => 'Jl. Kemang Raya No. 78, Jakarta Selatan',
                'phone' => '+622157890127',
                'email' => 'sweet@dreamsdesserts.com',
                'logo' => null,
                'cover_image' => null,
                'status' => 'active',
                'user_id' => User::where('email', 'budi@warungenak.com')->first()->id
            ],
            [
                'name' => 'Healthy Bites',
                'description' => 'Nutritious and delicious healthy food options. Our menu is designed for health-conscious individuals who don\'t want to compromise on taste.',
                'address' => 'Jl. Gatot Subroto No. 234, Jakarta Selatan',
                'phone' => '+622157890128',
                'email' => 'info@healthybites.com',
                'logo' => null,
                'cover_image' => null,
                'status' => 'active',
                'user_id' => User::where('email', 'sari@sushimaster.com')->first()->id
            ]
        ];

        foreach ($restaurants as $restaurant) {
            Restaurant::create($restaurant);
        }
    }
}
