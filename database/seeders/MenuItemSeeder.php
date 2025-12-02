<?php

namespace Database\Seeders;

use App\Models\MenuItem;
use App\Models\Restaurant;
use App\Models\Category;
use Illuminate\Database\Seeder;

class MenuItemSeeder extends Seeder
{
    public function run()
    {
        // Warung Enak - Indonesian
        $warungEnak = Restaurant::where('name', 'Warung Enak')->first();
        $indonesian = Category::where('name', 'Indonesian')->first();
        $beverages = Category::where('name', 'Beverages')->first();

        $warungEnakItems = [
            [
                'name' => 'Nasi Goreng Special',
                'description' => 'Traditional Indonesian fried rice with chicken, shrimp, egg, and special seasoning',
                'price' => 35000,
                'image' => null,
                'is_available' => true,
                'restaurant_id' => $warungEnak->id,
                'category_id' => $indonesian->id
            ],
            [
                'name' => 'Rendang Daging',
                'description' => 'Slow-cooked beef in rich coconut milk and spices, tender and flavorful',
                'price' => 45000,
                'image' => null,
                'is_available' => true,
                'restaurant_id' => $warungEnak->id,
                'category_id' => $indonesian->id
            ],
            [
                'name' => 'Gado-Gado',
                'description' => 'Fresh vegetable salad with peanut sauce, served with crackers',
                'price' => 25000,
                'image' => null,
                'is_available' => true,
                'restaurant_id' => $warungEnak->id,
                'category_id' => $indonesian->id
            ],
            [
                'name' => 'Sate Ayam',
                'description' => 'Chicken satay with peanut sauce, served with rice cakes',
                'price' => 30000,
                'image' => null,
                'is_available' => true,
                'restaurant_id' => $warungEnak->id,
                'category_id' => $indonesian->id
            ],
            [
                'name' => 'Es Teh Manis',
                'description' => 'Sweet iced tea, refreshing traditional drink',
                'price' => 8000,
                'image' => null,
                'is_available' => true,
                'restaurant_id' => $warungEnak->id,
                'category_id' => $beverages->id
            ]
        ];

        foreach ($warungEnakItems as $item) {
            MenuItem::create($item);
        }

        // Sushi Master - Japanese
        $sushiMaster = Restaurant::where('name', 'Sushi Master')->first();
        $japanese = Category::where('name', 'Japanese')->first();

        $sushiMasterItems = [
            [
                'name' => 'Salmon Sashimi',
                'description' => 'Fresh salmon slices served with wasabi and soy sauce',
                'price' => 85000,
                'image' => null,
                'is_available' => true,
                'restaurant_id' => $sushiMaster->id,
                'category_id' => $japanese->id
            ],
            [
                'name' => 'California Roll',
                'description' => 'Crab stick, avocado, cucumber, and mayonnaise wrapped in seaweed and rice',
                'price' => 65000,
                'image' => null,
                'is_available' => true,
                'restaurant_id' => $sushiMaster->id,
                'category_id' => $japanese->id
            ],
            [
                'name' => 'Tonkotsu Ramen',
                'description' => 'Rich pork bone broth ramen with chashu pork and soft-boiled egg',
                'price' => 55000,
                'image' => null,
                'is_available' => true,
                'restaurant_id' => $sushiMaster->id,
                'category_id' => $japanese->id
            ],
            [
                'name' => 'Chicken Teriyaki',
                'description' => 'Grilled chicken glazed with sweet teriyaki sauce, served with rice',
                'price' => 45000,
                'image' => null,
                'is_available' => true,
                'restaurant_id' => $sushiMaster->id,
                'category_id' => $japanese->id
            ],
            [
                'name' => 'Edamame',
                'description' => 'Steamed young soybeans with sea salt',
                'price' => 15000,
                'image' => null,
                'is_available' => true,
                'restaurant_id' => $sushiMaster->id,
                'category_id' => $japanese->id
            ]
        ];

        foreach ($sushiMasterItems as $item) {
            MenuItem::create($item);
        }

        // Burger Kingdom - Western/Fast Food
        $burgerKingdom = Restaurant::where('name', 'Burger Kingdom')->first();
        $western = Category::where('name', 'Western')->first();
        $fastFood = Category::where('name', 'Fast Food')->first();

        $burgerKingdomItems = [
            [
                'name' => 'Classic Beef Burger',
                'description' => '100% beef patty with lettuce, tomato, onion, and special sauce',
                'price' => 45000,
                'image' => null,
                'is_available' => true,
                'restaurant_id' => $burgerKingdom->id,
                'category_id' => $fastFood->id
            ],
            [
                'name' => 'Double Cheeseburger',
                'description' => 'Two beef patties with double cheese, bacon, and all the fixings',
                'price' => 65000,
                'image' => null,
                'is_available' => true,
                'restaurant_id' => $burgerKingdom->id,
                'category_id' => $fastFood->id
            ],
            [
                'name' => 'Crispy Chicken Burger',
                'description' => 'Crispy fried chicken fillet with mayo and fresh vegetables',
                'price' => 40000,
                'image' => null,
                'is_available' => true,
                'restaurant_id' => $burgerKingdom->id,
                'category_id' => $fastFood->id
            ],
            [
                'name' => 'French Fries',
                'description' => 'Golden crispy fries with your choice of seasoning',
                'price' => 20000,
                'image' => null,
                'is_available' => true,
                'restaurant_id' => $burgerKingdom->id,
                'category_id' => $fastFood->id
            ],
            [
                'name' => 'Chocolate Milkshake',
                'description' => 'Creamy chocolate milkshake topped with whipped cream',
                'price' => 25000,
                'image' => null,
                'is_available' => true,
                'restaurant_id' => $burgerKingdom->id,
                'category_id' => $beverages->id
            ]
        ];

        foreach ($burgerKingdomItems as $item) {
            MenuItem::create($item);
        }

        // Noodle House - Chinese
        $noodleHouse = Restaurant::where('name', 'Noodle House')->first();
        $chinese = Category::where('name', 'Chinese')->first();

        $noodleHouseItems = [
            [
                'name' => 'Beef Chow Mein',
                'description' => 'Stir-fried noodles with tender beef and fresh vegetables',
                'price' => 40000,
                'image' => null,
                'is_available' => true,
                'restaurant_id' => $noodleHouse->id,
                'category_id' => $chinese->id
            ],
            [
                'name' => 'Dim Sum Platter',
                'description' => 'Assorted dim sum including shrimp dumplings and pork buns',
                'price' => 55000,
                'image' => null,
                'is_available' => true,
                'restaurant_id' => $noodleHouse->id,
                'category_id' => $chinese->id
            ],
            [
                'name' => 'Sweet and Sour Chicken',
                'description' => 'Crispy chicken in tangy sweet and sour sauce',
                'price' => 48000,
                'image' => null,
                'is_available' => true,
                'restaurant_id' => $noodleHouse->id,
                'category_id' => $chinese->id
            ],
            [
                'name' => 'Wonton Soup',
                'description' => 'Delicate wontons in clear chicken broth',
                'price' => 30000,
                'image' => null,
                'is_available' => true,
                'restaurant_id' => $noodleHouse->id,
                'category_id' => $chinese->id
            ]
        ];

        foreach ($noodleHouseItems as $item) {
            MenuItem::create($item);
        }

        // Sweet Dreams Desserts - Desserts
        $sweetDreams = Restaurant::where('name', 'Sweet Dreams Desserts')->first();
        $desserts = Category::where('name', 'Desserts')->first();

        $sweetDreamsItems = [
            [
                'name' => 'Chocolate Lava Cake',
                'description' => 'Warm chocolate cake with molten chocolate center, served with vanilla ice cream',
                'price' => 35000,
                'image' => null,
                'is_available' => true,
                'restaurant_id' => $sweetDreams->id,
                'category_id' => $desserts->id
            ],
            [
                'name' => 'Tiramisu',
                'description' => 'Classic Italian dessert with coffee-soaked ladyfingers and mascarpone cream',
                'price' => 40000,
                'image' => null,
                'is_available' => true,
                'restaurant_id' => $sweetDreams->id,
                'category_id' => $desserts->id
            ],
            [
                'name' => 'Ice Cream Sundae',
                'description' => 'Three scoops of ice cream with chocolate sauce, nuts, and cherry',
                'price' => 28000,
                'image' => null,
                'is_available' => true,
                'restaurant_id' => $sweetDreams->id,
                'category_id' => $desserts->id
            ],
            [
                'name' => 'Fruit Tart',
                'description' => 'Buttery crust filled with custard and topped with fresh seasonal fruits',
                'price' => 32000,
                'image' => null,
                'is_available' => true,
                'restaurant_id' => $sweetDreams->id,
                'category_id' => $desserts->id
            ]
        ];

        foreach ($sweetDreamsItems as $item) {
            MenuItem::create($item);
        }

        // Healthy Bites - Healthy
        $healthyBites = Restaurant::where('name', 'Healthy Bites')->first();
        $healthy = Category::where('name', 'Healthy')->first();

        $healthyBitesItems = [
            [
                'name' => 'Quinoa Salad Bowl',
                'description' => 'Organic quinoa with mixed greens, avocado, cherry tomatoes, and lemon dressing',
                'price' => 45000,
                'image' => null,
                'is_available' => true,
                'restaurant_id' => $healthyBites->id,
                'category_id' => $healthy->id
            ],
            [
                'name' => 'Grilled Chicken Wrap',
                'description' => 'Whole wheat wrap with grilled chicken, hummus, and fresh vegetables',
                'price' => 38000,
                'image' => null,
                'is_available' => true,
                'restaurant_id' => $healthyBites->id,
                'category_id' => $healthy->id
            ],
            [
                'name' => 'Acai Bowl',
                'description' => 'Acai berry blend topped with granola, banana, and honey',
                'price' => 42000,
                'image' => null,
                'is_available' => true,
                'restaurant_id' => $healthyBites->id,
                'category_id' => $healthy->id
            ],
            [
                'name' => 'Green Smoothie',
                'description' => 'Spinach, banana, apple, and almond milk blended to perfection',
                'price' => 28000,
                'image' => null,
                'is_available' => true,
                'restaurant_id' => $healthyBites->id,
                'category_id' => $beverages->id
            ]
        ];

        foreach ($healthyBitesItems as $item) {
            MenuItem::create($item);
        }
    }
}
