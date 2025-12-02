<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Restaurant;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Get restaurant owned by this user
        $restaurant = Restaurant::where('user_id', $user->id)->first();

        if (!$restaurant) {
            // Jika owner belum punya restaurant, redirect ke create page
            return view('owner.no-restaurant', [
                'title' => 'Setup Your Restaurant'
            ]);
        }

        // Get restaurant statistics untuk SINGLE restaurant
        $stats = [
            'today_orders' => Order::where('restaurant_id', $restaurant->id)
                ->whereDate('created_at', today())
                ->count(),

            'pending_orders' => Order::where('restaurant_id', $restaurant->id)
                ->where('status', 'pending')
                ->count(),

            'preparing_orders' => Order::where('restaurant_id', $restaurant->id)
                ->where('status', 'preparing')
                ->count(),

            'today_revenue' => Order::where('restaurant_id', $restaurant->id)
                ->where('status', 'completed')
                ->whereDate('created_at', today())
                ->sum('total_amount'),

            'menu_items' => MenuItem::where('restaurant_id', $restaurant->id)->count(),

            // Growth calculations
            'growth' => $this->calculateOrderGrowth($restaurant->id),
            'revenue_growth' => $this->calculateRevenueGrowth($restaurant->id),
        ];

        // Recent orders dari SINGLE restaurant
        $recentOrders = Order::with(['orderItems.menuItem', 'user'])
            ->where('restaurant_id', $restaurant->id)
            ->latest()
            ->limit(5)
            ->get();

        // Popular menu items dari SINGLE restaurant
        $popularItems = MenuItem::where('restaurant_id', $restaurant->id)
            ->withCount(['orderItems as orders_count' => function($query) use ($restaurant) {
                $query->whereHas('order', function($q) use ($restaurant) {
                    $q->where('restaurant_id', $restaurant->id);
                });
            }])
            ->having('orders_count', '>', 0)
            ->orderBy('orders_count', 'desc')
            ->limit(4)
            ->get();

        return view('owner.dashboard', [
            'title' => 'Restaurant Dashboard',
            'restaurant' => $restaurant,
            'stats' => $stats,
            'recentOrders' => $recentOrders,
            'popularItems' => $popularItems
        ]);
    }

    /**
     * Calculate order growth percentage from yesterday
     */
    private function calculateOrderGrowth($restaurantId)
    {
        $todayOrders = Order::where('restaurant_id', $restaurantId)
            ->whereDate('created_at', today())
            ->count();

        $yesterdayOrders = Order::where('restaurant_id', $restaurantId)
            ->whereDate('created_at', today()->subDay())
            ->count();

        if ($yesterdayOrders == 0) {
            return $todayOrders > 0 ? 100 : 0;
        }

        return round((($todayOrders - $yesterdayOrders) / $yesterdayOrders) * 100);
    }

    /**
     * Calculate revenue growth percentage from yesterday
     */
    private function calculateRevenueGrowth($restaurantId)
    {
        $todayRevenue = Order::where('restaurant_id', $restaurantId)
            ->where('status', 'completed')
            ->whereDate('created_at', today())
            ->sum('total_amount');

        $yesterdayRevenue = Order::where('restaurant_id', $restaurantId)
            ->where('status', 'completed')
            ->whereDate('created_at', today()->subDay())
            ->sum('total_amount');

        if ($yesterdayRevenue == 0) {
            return $todayRevenue > 0 ? 100 : 0;
        }

        return round((($todayRevenue - $yesterdayRevenue) / $yesterdayRevenue) * 100);
    }
}
