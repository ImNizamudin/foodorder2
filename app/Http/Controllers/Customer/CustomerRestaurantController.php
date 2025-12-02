<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\Category;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CustomerRestaurantController extends Controller
{
    public function index(Request $request)
    {
        $query = Restaurant::where('status', 'active')
            ->with(['menuItems' => function($query) {
                $query->where('is_available', true)
                    ->with('category');
            }])
            ->withCount(['menuItems' => function($query) {
                $query->where('is_available', true);
            }]);

        // Search filter
        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', "%$searchTerm%")
                  ->orWhere('description', 'like', "%$searchTerm%")
                  ->orWhereHas('menuItems', function($q) use ($searchTerm) {
                      $q->where('name', 'like', "%$searchTerm%");
                  });
            });
        }

        // ✅ Category filter - Handle single category parameter
        if ($request->has('category')) {
            $categoryName = $request->category;
            Log::info('Filtering by category:', ['category' => $categoryName]);

            $query->whereHas('menuItems.category', function($q) use ($categoryName) {
                $q->where('name', $categoryName);
            });
        }

        // ✅ Categories filter (multiple) - Handle categories[] parameter
        if ($request->has('categories')) {
            $categories = $request->categories;
            Log::info('Filtering by categories:', ['categories' => $categories]);

            $query->whereHas('menuItems.category', function($q) use ($categories) {
                if (is_array($categories)) {
                    $q->whereIn('name', $categories);
                } else {
                    $q->where('name', $categories);
                }
            });
        }

        // Sort options
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'rating':
                    $query->orderBy('name');
                    break;
                case 'delivery_time':
                    $query->orderBy('name');
                    break;
                case 'price_low':
                    $query->select('restaurants.*')
                        ->leftJoin('menu_items', 'restaurants.id', '=', 'menu_items.restaurant_id')
                        ->where('menu_items.is_available', true)
                        ->orderBy('menu_items.price', 'asc');
                    break;
                case 'price_high':
                    $query->select('restaurants.*')
                        ->leftJoin('menu_items', 'restaurants.id', '=', 'menu_items.restaurant_id')
                        ->where('menu_items.is_available', true)
                        ->orderBy('menu_items.price', 'desc');
                    break;
                default:
                    $query->orderBy('menu_items_count', 'desc');
                    break;
            }
        } else {
            $query->orderBy('menu_items_count', 'desc');
        }

        $restaurants = $query->get();

        // Get all categories for filter sidebar
        $categories = Category::where('is_active', true)
            ->withCount(['menuItems' => function($query) {
                $query->where('is_available', true);
            }])
            ->get()
            ->map(function($category) {
                $category->icon = $this->getCategoryIcon($category->name);
                return $category;
            });

        // Get personalized recommendations
        $recommendations = $this->getPersonalizedRecommendations();

        // Log untuk debugging
        Log::info('Restaurant search parameters:', [
            'search' => $request->search,
            'category' => $request->category,
            'categories' => $request->categories,
            'count' => $restaurants->count()
        ]);

        return view('customer.restaurants.index', [
            'title' => $this->generatePageTitle($request),
            'restaurants' => $restaurants,
            'categories' => $categories,
            'search' => $request->search,
            'selectedCategory' => $request->category,
            'selectedCategories' => $request->categories ?? [],
            'recommendations' => $recommendations,
            'activeFilters' => $request->except(['_token', 'page'])
        ]);
    }

    /**
     * Generate dynamic page title based on filters
     */
    private function generatePageTitle(Request $request)
    {
        if ($request->has('search')) {
            return "Search: '{$request->search}' - FoodOrder";
        }

        if ($request->has('category')) {
            return "{$request->category} Restaurants - FoodOrder";
        }

        if ($request->has('categories')) {
            $categories = is_array($request->categories)
                ? implode(', ', $request->categories)
                : $request->categories;
            return "{$categories} Restaurants - FoodOrder";
        }

        return 'Discover Restaurants - FoodOrder';
    }

    /**
     * Get personalized recommendations based on user history
     */
    private function getPersonalizedRecommendations()
    {
        $hour = now()->hour;
        $recommendations = [];

        // Time-based recommendations
        $timeBasedKey = '';
        $timeBasedTitle = '';

        if ($hour >= 6 && $hour <= 10) {
            $timeBasedKey = 'breakfast';
            $timeBasedTitle = '⏰ Perfect for Breakfast';
        } elseif ($hour >= 11 && $hour <= 14) {
            $timeBasedKey = 'lunch';
            $timeBasedTitle = '⏰ Perfect for Lunch';
        } else {
            $timeBasedKey = 'dinner';
            $timeBasedTitle = '⏰ Perfect for Dinner';
        }

        // Get recommendations based on popular categories
        $recommendations[$timeBasedKey] = [
            'title' => $timeBasedTitle,
            'description' => 'Great options for your current time',
            'restaurants' => Restaurant::where('status', 'active')
                ->withCount(['menuItems' => function($query) {
                    $query->where('is_available', true);
                }])
                ->orderBy('menu_items_count', 'desc')
                ->limit(3)
                ->get()
        ];

        // Popular near you
        $recommendations['popular'] = [
            'title' => '🔥 Popular Near You',
            'description' => 'Trending restaurants in your area',
            'restaurants' => Restaurant::where('status', 'active')
                ->withCount(['menuItems' => function($query) {
                    $query->where('is_available', true);
                }])
                ->orderBy('menu_items_count', 'desc')
                ->skip(3)
                ->limit(3)
                ->get()
        ];

        return $recommendations;
    }

    public function show(Restaurant $restaurant)
    {
        if ($restaurant->status !== 'active') {
            abort(404);
        }

        // Load menu items with categories and group by category
        $menuItems = $restaurant->menuItems()
            ->where('is_available', true)
            ->with('category')
            ->get()
            ->groupBy('category.name');

        // Get cart items for this restaurant
        $cart = session()->get('cart', []);
        $cartItems = [];
        $cartTotal = 0;
        $cartCount = 0;

        foreach ($cart as $item) {
            $menuItem = MenuItem::find($item['menu_item_id']);
            if ($menuItem && $menuItem->restaurant_id === $restaurant->id) {
                $cartItems[] = [
                    'id' => $menuItem->id,
                    'name' => $menuItem->name,
                    'price' => $menuItem->price,
                    'quantity' => $item['quantity'],
                    'image' => $menuItem->image,
                    'customizations' => $item['customizations'] ?? []
                ];
                $cartTotal += $menuItem->price * $item['quantity'];
                $cartCount += $item['quantity'];
            }
        }

        // Track user view for personalization
        $this->trackUserInteraction('view_restaurant', $restaurant->id);

        return view('customer.restaurants.show', [
            'title' => $restaurant->name . ' - FoodOrder',
            'restaurant' => $restaurant,
            'menuItems' => $menuItems,
            'cartItems' => $cartItems,
            'cartTotal' => $cartTotal,
            'cartCount' => $cartCount
        ]);
    }

    private function trackUserInteraction($type, $restaurantId)
    {
        Log::info("User interaction: {$type} for restaurant {$restaurantId}");
    }

    /**
     * Get appropriate icon for each category
     */
    private function getCategoryIcon($categoryName)
    {
        $icons = [
            'Indonesian' => 'bx bx-rice-bowl',
            'Western' => 'bx bx-burger',
            'Japanese' => 'bx bx-sushi',
            'Chinese' => 'bx bx-noodle',
            'Desserts' => 'bx bx-ice-cream',
            'Beverages' => 'bx bx-coffee',
            'Healthy' => 'bx bx-salad',
            'Fast Food' => 'bx bx-french-fries',
            'Italian' => 'bx bx-pizza',
            'Thai' => 'bx bx-bowl-rice',
            'Mexican' => 'bx bx-pepper',
            'Indian' => 'bx bx-curry'
        ];

        return $icons[$categoryName] ?? 'bx bx-food-tag';
    }
}
