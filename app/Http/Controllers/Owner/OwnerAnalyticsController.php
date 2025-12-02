<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Restaurant;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OwnerAnalyticsController extends Controller
{
    public function index()
    {
        $restaurant = Restaurant::where('user_id', Auth::id())->firstOrFail();

        // Basic statistics
        $stats = $this->getBasicStats($restaurant);

        // Daily revenue for chart
        $revenueData = $this->getRevenueData($restaurant);

        // Popular items
        $popularItems = $this->getPopularItems($restaurant);

        // Order trends
        $orderTrends = $this->getOrderTrends($restaurant);

        return view('owner.analytics.index', [
            'title' => 'Restaurant Analytics',
            'restaurant' => $restaurant,
            'stats' => $stats,
            'revenueData' => $revenueData,
            'popularItems' => $popularItems,
            'orderTrends' => $orderTrends
        ]);
    }

    public function salesReport(Request $request)
    {
        $restaurant = Restaurant::where('user_id', Auth::id())->firstOrFail();

        $startDate = $request->get('start_date', now()->subMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->format('Y-m-d'));

        $orders = Order::with('orderItems.menuItem')
            ->where('restaurant_id', $restaurant->id)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->where('status', 'completed')
            ->get();

        $reportData = [
            'total_orders' => $orders->count(),
            'total_revenue' => $orders->sum('total_amount'),
            'average_order_value' => $orders->avg('total_amount') ?? 0,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'orders' => $orders
        ];

        return view('owner.analytics.sales-report', [
            'title' => 'Sales Report',
            'restaurant' => $restaurant,
            'report' => $reportData
        ]);
    }

    private function getBasicStats($restaurant)
    {
        $today = now()->format('Y-m-d');
        $lastWeek = now()->subWeek()->format('Y-m-d');

        return [
            // Today's stats
            'today_orders' => Order::where('restaurant_id', $restaurant->id)
                ->whereDate('created_at', $today)
                ->count(),
            'today_revenue' => Order::where('restaurant_id', $restaurant->id)
                ->where('status', 'completed')
                ->whereDate('created_at', $today)
                ->sum('total_amount'),

            // Weekly stats
            'weekly_orders' => Order::where('restaurant_id', $restaurant->id)
                ->whereDate('created_at', '>=', $lastWeek)
                ->count(),
            'weekly_revenue' => Order::where('restaurant_id', $restaurant->id)
                ->where('status', 'completed')
                ->whereDate('created_at', '>=', $lastWeek)
                ->sum('total_amount'),

            // Monthly stats
            'monthly_orders' => Order::where('restaurant_id', $restaurant->id)
                ->whereMonth('created_at', now()->month)
                ->count(),
            'monthly_revenue' => Order::where('restaurant_id', $restaurant->id)
                ->where('status', 'completed')
                ->whereMonth('created_at', now()->month)
                ->sum('total_amount'),

            // All time
            'total_orders' => Order::where('restaurant_id', $restaurant->id)->count(),
            'total_revenue' => Order::where('restaurant_id', $restaurant->id)
                ->where('status', 'completed')
                ->sum('total_amount'),

            // Average order value
            'avg_order_value' => Order::where('restaurant_id', $restaurant->id)
                ->where('status', 'completed')
                ->avg('total_amount') ?? 0,
        ];
    }

    private function getRevenueData($restaurant)
    {
        $revenueData = Order::where('restaurant_id', $restaurant->id)
            ->where('status', 'completed')
            ->whereDate('created_at', '>=', now()->subDays(30))
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total_amount) as revenue')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return $revenueData;
    }

    private function getPopularItems($restaurant)
    {
        return MenuItem::where('restaurant_id', $restaurant->id)
            ->withCount(['orderItems as total_orders' => function($query) {
                $query->select(DB::raw('COALESCE(SUM(quantity), 0)'));
            }])
            ->withCount(['orderItems as total_revenue' => function($query) {
                $query->select(DB::raw('COALESCE(SUM(total_price), 0)'));
            }])
            ->orderBy('total_orders', 'desc')
            ->limit(10)
            ->get();
    }

    private function getOrderTrends($restaurant)
    {
        return Order::where('restaurant_id', $restaurant->id)
            ->whereDate('created_at', '>=', now()->subDays(7))
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as order_count'),
                DB::raw('SUM(CASE WHEN status = "completed" THEN total_amount ELSE 0 END) as revenue')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }

    private function getOrderStatusCounts($restaurant)
    {
        return [
            'pending' => Order::where('restaurant_id', $restaurant->id)->where('status', 'pending')->count(),
            'confirmed' => Order::where('restaurant_id', $restaurant->id)->where('status', 'confirmed')->count(),
            'preparing' => Order::where('restaurant_id', $restaurant->id)->where('status', 'preparing')->count(),
            'ready' => Order::where('restaurant_id', $restaurant->id)->where('status', 'ready')->count(),
            'completed' => Order::where('restaurant_id', $restaurant->id)->where('status', 'completed')->count(),
            'cancelled' => Order::where('restaurant_id', $restaurant->id)->where('status', 'cancelled')->count(),
        ];
    }
}
