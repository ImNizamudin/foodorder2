<?php
// app/Http/Controllers/Customer/HomeController.php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\Category;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            // Get real data from database
            $featuredRestaurants = Restaurant::where('status', 'active')
                ->with(['menuItems' => function($query) {
                    $query->where('is_available', true)->limit(3);
                }])
                ->limit(6)
                ->get()
                ->map(function($restaurant) {
                    // Tambahkan cover image URL
                    $restaurant->cover_image_url = $this->getRestaurantCoverImage($restaurant);
                    // Tambahkan cuisine types
                    $restaurant->cuisine_types = $this->getCuisineTypes($restaurant);
                    return $restaurant;
                });

            $categories = Category::where('is_active', true)
                ->withCount(['menuItems' => function($query) {
                    $query->where('is_available', true);
                }])
                ->get()
                ->map(function($category) {
                    // Add specific icons for each category
                    $category->icon = $this->getCategoryIcon($category->name);
                    $category->color = $this->getCategoryColor($category->name);
                    return $category;
                });

            $popularDishes = MenuItem::where('is_available', true)
                ->with('restaurant')
                ->inRandomOrder()
                ->limit(8)
                ->get();

            return view('customer.home', [
                'title' => 'FoodOrder - Discover Amazing Food',
                'featuredRestaurants' => $featuredRestaurants,
                'categories' => $categories,
                'popularDishes' => $popularDishes
            ]);
        }

        return view('customer.landing', [
            'title' => 'FoodOrder - Order Makanan Online'
        ]);
    }

    private function getRestaurantCoverImage(Restaurant $restaurant)
    {
        // Jika restaurant memiliki cover image sendiri
        if ($restaurant->cover_image && file_exists(public_path('storage/' . $restaurant->cover_image))) {
            return asset('storage/' . $restaurant->cover_image);
        }

        // Jika restaurant memiliki logo
        if ($restaurant->logo && file_exists(public_path('storage/' . $restaurant->logo))) {
            return asset('storage/' . $restaurant->logo);
        }

        // Fallback ke random food images dari Unsplash berdasarkan kategori restaurant
        return $this->getRandomFoodImage($restaurant);
    }

    /**
     * Get random food image from Unsplash based on restaurant's cuisine
     */
    private function getRandomFoodImage(Restaurant $restaurant)
    {
        // Dapatkan kategori utama dari restaurant (dari menu items)
        $cuisineTypes = $this->getCuisineTypes($restaurant);
        $primaryCuisine = count($cuisineTypes) > 0 ? $cuisineTypes[0] : 'food';

        // Map cuisine ke keyword Unsplash
        $unsplashKeywords = [
            'Indonesian' => 'indonesian+food',
            'Western' => 'western+food+burger',
            'Japanese' => 'japanese+sushi',
            'Chinese' => 'chinese+noodles',
            'Italian' => 'italian+pizza',
            'Thai' => 'thai+food',
            'Mexican' => 'mexican+tacos',
            'Indian' => 'indian+curry',
            'Desserts' => 'desserts+cake',
            'Beverages' => 'beverages+drink',
            'Healthy' => 'healthy+salad',
            'Fast Food' => 'fast+food',
        ];

        $keyword = $unsplashKeywords[$primaryCuisine] ?? 'delicious+food';

        // Generate Unsplash URL dengan parameter untuk konsistensi berdasarkan restaurant ID
        $restaurantHash = crc32($restaurant->id);
        $imageNumber = ($restaurantHash % 10) + 1; // 1-10

        // List Unsplash image IDs untuk berbagai makanan
        $unsplashImages = [
            'food1' => 'TAC0JuM6SO4', // Burger
            'food2' => 'f1H6GmCF7lM', // Pizza
            'food3' => 'h1LK2l5A7oQ', // Sushi
            'food4' => 'zAhw5Xe1Lvs', // Noodles
            'food5' => 'eHzwd6rYIhI', // Curry
            'food6' => 'Yr4n8O_3UPc', // Tacos
            'food7' => 'kZE9_8rzh3k', // Salad
            'food8' => 'zGZYQQVmXW0', // Dessert
            'food9' => 'N0u8bLrB_-g', // Coffee
            'food10' => 'jpkfc5_d-DI', // Breakfast
        ];

        // Pilih image berdasarkan hash restaurant untuk konsistensi
        $imageKeys = array_keys($unsplashImages);
        $selectedKey = $imageKeys[$imageNumber - 1];
        $imageId = $unsplashImages[$selectedKey];

        return "https://images.unsplash.com/photo-{$imageId}?auto=format&fit=crop&w=600&h=400&q=80";
    }

    /**
     * Get cuisine types from restaurant's menu items
     */
    private function getCuisineTypes(Restaurant $restaurant)
    {
        return $restaurant->menuItems
            ->load('category')
            ->pluck('category.name')
            ->filter()
            ->unique()
            ->values()
            ->toArray();
    }

    /**
     * Get restaurant's price range symbol
     */
    private function getPriceRangeSymbol($priceRange)
    {
        $symbols = [
            1 => '💰',
            2 => '💰💰',
            3 => '💰💰💰',
            4 => '💰💰💰💰'
        ];

        return $symbols[$priceRange] ?? '💰💰';
    }

    public function searchSuggestions(Request $request)
    {
        $query = $request->get('q', '');

        $suggestions = [
            'categories' => Category::where('is_active', true)
                ->where(function($q) use ($query) {
                    $q->where('name', 'like', "%$query%")
                    ->orWhere('description', 'like', "%$query%");
                })
                ->limit(5)
                ->get(['id', 'name', 'slug']), // ✅ Tambah slug

            'restaurants' => Restaurant::where('status', 'active')
                ->where('name', 'like', "%$query%")
                ->limit(5)
                ->get(['id', 'name']),

            'dishes' => MenuItem::where('is_available', true)
                ->where('name', 'like', "%$query%")
                ->with('restaurant:id,name') // ✅ Load restaurant name
                ->limit(5)
                ->get(['id', 'name', 'restaurant_id'])
        ];

        return response()->json($suggestions);
    }

    public function popularSearchSuggestions()
    {
        $popular = [
            'categories' => Category::where('is_active', true)
                ->orderByRaw('(SELECT COUNT(*) FROM menu_items WHERE menu_items.category_id = categories.id) DESC')
                ->limit(8)
                ->get(['id', 'name', 'slug']), // ✅ Tambah slug

            'dishes' => MenuItem::where('is_available', true)
                ->with('restaurant:id,name') // ✅ Load restaurant name
                ->inRandomOrder()
                ->limit(8)
                ->get(['id', 'name', 'restaurant_id'])
        ];

        return response()->json($popular);
    }

    private function getCategoryIcon($categoryName)
    {
        $icons = [
            'Indonesian' => 'fi fi-rs-restaurant',
            'Western' => 'fi fi-rs-hamburger',
            'Japanese' => 'fi fi-rs-sushi',
            'Chinese' => 'fi fi-rs-noodles',
            'Desserts' => 'fi fi-rs-ice-cream',
            'Beverages' => 'fi fi-rs-coffee',
            'Healthy' => 'fi fi-rs-salad',
            'Fast Food' => 'fi fi-rs-french-fries',
            'Italian' => 'fi fi-rs-pizza',
            'Thai' => 'fi fi-rs-bowl-rice',
            'Mexican' => 'fi fi-rs-pepper-hot',
            'Indian' => 'fi fi-rs-curry'
        ];

        return $icons[$categoryName] ?? 'fi fi-rs-food';
    }

    private function getCategoryColor($categoryName)
    {
        $colors = [
            'Indonesian' => 'from-orange-400 to-red-500',
            'Western' => 'from-blue-400 to-purple-500',
            'Japanese' => 'from-red-400 to-pink-500',
            'Chinese' => 'from-yellow-400 to-orange-500',
            'Desserts' => 'from-pink-400 to-rose-500',
            'Beverages' => 'from-cyan-400 to-blue-500',
            'Healthy' => 'from-green-400 to-emerald-500',
            'Fast Food' => 'from-orange-400 to-amber-500',
            'Italian' => 'from-red-400 to-orange-500',
            'Thai' => 'from-green-400 to-lime-500',
            'Mexican' => 'from-red-500 to-orange-600',
            'Indian' => 'from-yellow-500 to-orange-600'
        ];

        return $colors[$categoryName] ?? 'from-primary-400 to-primary-600';
    }
}
