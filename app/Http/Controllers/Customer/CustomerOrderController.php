<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CustomerOrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::where('user_id', auth()->id())
            ->with(['restaurant', 'orderItems.menuItem']);

        // Apply filters
        if ($request->has('filter') && $request->filter !== 'all') {
            $query->where('status', $request->filter);
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(10);

        $orderStats = [
            'total' => Order::where('user_id', auth()->id())->count(),
            'pending' => Order::where('user_id', auth()->id())->whereIn('status', ['pending', 'confirmed', 'preparing'])->count(),
            'completed' => Order::where('user_id', auth()->id())->where('status', 'completed')->count(),
            'cancelled' => Order::where('user_id', auth()->id())->where('status', 'cancelled')->count(),
        ];

        return view('customer.orders.index', [
            'title' => 'My Orders - FoodOrder',
            'orders' => $orders,
            'orderStats' => $orderStats,
            'filter' => $request->filter ?? 'all'
        ]);
    }

    public function show(Order $order)
    {
        // Authorization - ensure user can only view their own orders
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load(['restaurant', 'orderItems.menuItem', 'user']);

        // Calculate estimated delivery time
        $estimatedDelivery = $this->calculateEstimatedDelivery($order);

        // Get detailed timeline
        $timeline = $this->getOrderTimeline($order);

        return view('customer.orders.track', [
            'title' => 'Track Order #' . $order->order_number . ' - FoodOrder',
            'order' => $order,
            'estimatedDelivery' => $estimatedDelivery,
            'timeline' => $timeline
        ]);
    }

    public function confirmation(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load(['restaurant', 'orderItems.menuItem']);

        return view('customer.orders.confirmation', [
            'title' => 'Order Confirmed - FoodOrder',
            'order' => $order,
            'estimatedDelivery' => $this->calculateEstimatedDelivery($order)
        ]);
    }

    public function track(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load(['restaurant', 'orderItems.menuItem']);

        // Simulate driver location (in real app, this would come from driver app)
        $driverLocation = $this->simulateDriverLocation($order);

        // Simulate status progression for demo
        $this->simulateStatusProgression($order);

        return response()->json([
            'success' => true,
            'order' => [
                'id' => $order->id,
                'order_number' => $order->order_number,
                'status' => $order->status,
                'status_badge' => $order->status_badge,
                'status_text' => $order->status_text,
                'timeline' => $this->getOrderTimeline($order),
                'estimated_delivery' => $this->calculateEstimatedDelivery($order),
                'driver_location' => $driverLocation,
                'restaurant' => [
                    'name' => $order->restaurant->name,
                    'address' => $order->restaurant->address,
                    'phone' => $order->restaurant->phone
                ],
                'last_updated' => now()->format('h:i A')
            ]
        ]);
    }

    public function cancel(Order $order, Request $request)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        // Only allow cancellation for pending/confirmed orders
        if (!in_array($order->status, ['pending', 'confirmed'])) {
            return response()->json([
                'success' => false,
                'message' => 'Order cannot be cancelled at this stage'
            ], 400);
        }

        DB::beginTransaction();
        try {
            $order->update([
                'status' => 'cancelled',
                'cancellation_reason' => $request->reason
            ]);

            // Log cancellation
            Log::info('Order cancelled', [
                'order_id' => $order->id,
                'user_id' => auth()->id(),
                'reason' => $request->reason
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Order cancelled successfully'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to cancel order'
            ], 500);
        }
    }

    public function reorder(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        // Add all items from previous order to cart
        $cart = session()->get('cart', []);

        foreach ($order->orderItems as $item) {
            $cart[] = [
                'menu_item_id' => $item->menu_item_id,
                'quantity' => $item->quantity,
                'customizations' => $item->customizations ?? [],
                'added_at' => now()->toISOString()
            ];
        }

        // Save to cart session
        session()->put('cart', $cart);

        return response()->json([
            'success' => true,
            'message' => 'Items added to cart successfully',
            'redirect_url' => route('customer.cart')
        ]);
    }

    public function addReview(Order $order, Request $request)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        // Only allow reviews for completed orders
        if ($order->status !== 'completed') {
            return response()->json([
                'success' => false,
                'message' => 'You can only review completed orders'
            ], 400);
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500'
        ]);

        // Update the order with review
        $order->update([
            'customer_rating' => $request->rating,
            'customer_review' => $request->comment,
            'reviewed_at' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Thank you for your review!'
        ]);
    }

    // Helper Methods
    private function calculateEstimatedDelivery(Order $order)
    {
        $baseTime = $order->created_at ?? now();

        switch ($order->status) {
            case 'pending':
                return $baseTime->addMinutes(40);
            case 'confirmed':
                return $baseTime->addMinutes(35);
            case 'preparing':
                return $baseTime->addMinutes(25);
            case 'ready':
                return $baseTime->addMinutes(15);
            case 'on_the_way':
                return $baseTime->addMinutes(10);
            default:
                return $baseTime->addMinutes(30);
        }
    }

    private function getOrderTimeline(Order $order)
    {
        $timeline = [
            'order_placed' => [
                'status' => 'completed',
                'time' => $order->created_at,
                'description' => 'Order placed'
            ],
            'order_confirmed' => [
                'status' => in_array($order->status, ['confirmed', 'preparing', 'ready', 'on_the_way', 'completed']) ? 'completed' : 'pending',
                'time' => $order->confirmed_at,
                'description' => 'Order confirmed by restaurant'
            ],
            'food_preparing' => [
                'status' => in_array($order->status, ['preparing', 'ready', 'on_the_way', 'completed']) ? 'completed' : 'pending',
                'time' => $order->preparing_at,
                'description' => 'Food is being prepared'
            ],
            'food_ready' => [
                'status' => in_array($order->status, ['ready', 'on_the_way', 'completed']) ? 'completed' : 'pending',
                'time' => $order->ready_at,
                'description' => 'Food is ready for pickup'
            ],
            'on_the_way' => [
                'status' => in_array($order->status, ['on_the_way', 'completed']) ? 'completed' : 'pending',
                'time' => $order->on_the_way_at,
                'description' => 'Driver is on the way'
            ],
            'delivered' => [
                'status' => $order->status === 'completed' ? 'completed' : 'pending',
                'time' => $order->completed_at,
                'description' => 'Order delivered'
            ]
        ];

        return $timeline;
    }

    private function simulateDriverLocation(Order $order)
    {
        // In real app, this would come from driver's GPS
        // For simulation, return random coordinates near restaurant
        $restaurant = $order->restaurant;

        return [
            'lat' => -6.2 + (rand(-100, 100) / 1000), // Near Jakarta
            'lng' => 106.8 + (rand(-100, 100) / 1000),
            'address' => 'Approaching your location...'
        ];
    }

    private function simulateStatusProgression(Order $order)
    {
        // Only for demo - simulate status progression based on order age
        $orderAge = now()->diffInMinutes($order->created_at);

        if ($order->status === 'pending' && $orderAge > 2) {
            $order->update(['status' => 'confirmed', 'confirmed_at' => now()]);
        } elseif ($order->status === 'confirmed' && $orderAge > 5) {
            $order->update(['status' => 'preparing', 'preparing_at' => now()]);
        } elseif ($order->status === 'preparing' && $orderAge > 10) {
            $order->update(['status' => 'ready', 'ready_at' => now()]);
        } elseif ($order->status === 'ready' && $orderAge > 12) {
            $order->update(['status' => 'on_the_way', 'on_the_way_at' => now()]);
        } elseif ($order->status === 'on_the_way' && $orderAge > 15) {
            $order->update(['status' => 'completed', 'completed_at' => now()]);
        }
    }
}
