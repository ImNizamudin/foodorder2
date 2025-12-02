<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OwnerOrderController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $restaurant = $user->restaurant;

        if (!$restaurant) {
            return redirect()->route('owner.restaurants.create')
                ->with('error', 'You need to create a restaurant first.');
        }

        // Base query
        $query = Order::with(['user', 'orderItems.menuItem'])
            ->where('restaurant_id', $restaurant->id);

        // Apply filters - Default to all status
        if ($request->has('status') && $request->status != '' && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                ->orWhereHas('user', function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                });
            });
        }

        // Date filtering - Default to all time
        if ($request->has('date_filter') && $request->date_filter != 'all') {
            switch ($request->date_filter) {
                case 'today':
                    $query->whereDate('created_at', today());
                    break;
                case 'yesterday':
                    $query->whereDate('created_at', today()->subDay());
                    break;
                case 'week':
                    $query->where('created_at', '>=', now()->subWeek());
                    break;
                case 'month':
                    $query->where('created_at', '>=', now()->subMonth());
                    break;
            }
        }

        $orders = $query->latest()->paginate(15);

        // Statistics - Active Orders Today (confirmed, preparing, ready)
        $activeOrdersToday = Order::where('restaurant_id', $restaurant->id)
            ->whereIn('status', ['confirmed', 'preparing', 'ready'])
            ->whereDate('created_at', today())
            ->count();

        $stats = [
            'today_orders' => Order::where('restaurant_id', $restaurant->id)
                ->whereDate('created_at', today())
                ->count(),
            'active_orders_today' => $activeOrdersToday,
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
            'growth' => $this->calculateActiveOrdersGrowth($restaurant->id),
            'revenue_growth' => $this->calculateRevenueGrowth($restaurant->id),
        ];

        return view('owner.orders.index', [
            'title' => 'Order Management',
            'orders' => $orders,
            'stats' => $stats,
            'filters' => $request->all()
        ]);
    }

    public function show(Order $order)
    {
        // Verify ownership
        $user = Auth::user();
        $restaurant = $user->restaurant;

        if (!$restaurant || $order->restaurant_id !== $restaurant->id) {
            abort(403, 'Unauthorized action.');
        }

        // Load relationships
        $order->load(['user', 'orderItems.menuItem']);

        return view('owner.orders.show', [
            'title' => 'Order ' . $order->order_number,
            'order' => $order,
            'restaurant' => $restaurant
        ]);
    }

    public function printReceipt(Order $order)
    {
        // Verify ownership
        $user = Auth::user();
        $restaurant = $user->restaurant;

        if (!$restaurant || $order->restaurant_id !== $restaurant->id) {
            abort(403, 'Unauthorized action.');
        }

        // Load relationships
        $order->load(['user', 'orderItems.menuItem', 'restaurant']);

        return view('owner.orders.receipt', [
            'order' => $order,
            'restaurant' => $restaurant
        ]);
    }

    public function updateStatus(Request $request, Order $order)
    {
        // Verify ownership
        $user = Auth::user();
        $restaurant = $user->restaurant;

        if (!$restaurant || $order->restaurant_id !== $restaurant->id) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'status' => 'required|in:pending,confirmed,preparing,ready,completed,cancelled'
        ]);

        try {
            $previousStatus = $order->status;
            $order->update([
                'status' => $request->status,
                'updated_at' => now()
            ]);

            $message = "Order status updated to " . ucfirst($request->status) . "!";

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => $message,
                    'status' => $order->status,
                    'status_badge' => $this->getStatusBadge($order->status)
                ]);
            }

            return redirect()->back()->with('success', $message);

        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update order status.'
                ], 500);
            }

            return redirect()->back()->with('error', 'Failed to update order status.');
        }
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

    private function calculateActiveOrdersGrowth($restaurantId)
    {
        $todayActiveOrders = Order::where('restaurant_id', $restaurantId)
            ->whereIn('status', ['confirmed', 'preparing', 'ready'])
            ->whereDate('created_at', today())
            ->count();

        $yesterdayActiveOrders = Order::where('restaurant_id', $restaurantId)
            ->whereIn('status', ['confirmed', 'preparing', 'ready'])
            ->whereDate('created_at', today()->subDay())
            ->count();

        if ($yesterdayActiveOrders == 0) {
            return $todayActiveOrders > 0 ? 100 : 0;
        }

        return round((($todayActiveOrders - $yesterdayActiveOrders) / $yesterdayActiveOrders) * 100);
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

    private function getStatusBadge($status)
    {
        $badges = [
            'pending' => 'bg-yellow-100 text-yellow-800 border border-yellow-200',
            'confirmed' => 'bg-blue-100 text-blue-800 border border-blue-200',
            'preparing' => 'bg-orange-100 text-orange-800 border border-orange-200',
            'ready' => 'bg-green-100 text-green-800 border border-green-200',
            'completed' => 'bg-gray-100 text-gray-800 border border-gray-200',
            'cancelled' => 'bg-red-100 text-red-800 border border-red-200'
        ];

        return $badges[$status] ?? $badges['pending'];
    }
}
