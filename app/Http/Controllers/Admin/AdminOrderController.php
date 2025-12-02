<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'restaurant', 'orderItems'])
            ->latest()
            ->paginate(10);

        // Order statistics
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $completedOrders = Order::where('status', 'completed')->count();
        $totalRevenue = Order::where('status', 'completed')->sum('total_amount');

        return view('admin.orders.index', [
            'title' => 'Order Management',
            'orders' => $orders,
            'stats' => [
                'total' => $totalOrders,
                'pending' => $pendingOrders,
                'completed' => $completedOrders,
                'revenue' => $totalRevenue
            ]
        ]);
    }

    public function show(Order $order)
    {
        $order->load(['user', 'restaurant', 'orderItems.menuItem']);

        return view('admin.orders.show', [
            'title' => 'Order Details - ' . $order->order_number,
            'order' => $order
        ]);
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => ['required', 'in:pending,confirmed,preparing,ready,completed,cancelled']
        ]);

        $order->update([
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'Order status updated successfully.');
    }

    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()->route('admin.orders')->with('success', 'Order deleted successfully.');
    }
}
