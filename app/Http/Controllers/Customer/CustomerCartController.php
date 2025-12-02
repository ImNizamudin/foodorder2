<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CustomerCartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $cartItems = [];
        $total = 0;

        foreach ($cart as $item) {
            $menuItem = MenuItem::with('restaurant')->find($item['menu_item_id']);
            if ($menuItem) {
                $itemTotal = $menuItem->price * $item['quantity'];
                $cartItems[] = [
                    'menu_item' => $menuItem,
                    'quantity' => $item['quantity'],
                    'total_price' => $itemTotal,
                    'customizations' => $item['customizations'] ?? []
                ];
                $total += $itemTotal;
            }
        }

        return view('customer.cart.index', [
            'title' => 'Shopping Cart - FoodOrder',
            'cartItems' => $cartItems,
            'total' => $total
        ]);
    }

    public function getCart()
    {
        $cart = session()->get('cart', []);
        $cartItems = [];
        $cartCount = 0;

        foreach ($cart as $item) {
            $menuItem = MenuItem::find($item['menu_item_id']);
            if ($menuItem) {
                $cartItems[] = [
                    'id' => $menuItem->id,
                    'name' => $menuItem->name,
                    'price' => $menuItem->price,
                    'quantity' => $item['quantity'],
                    'image' => $menuItem->image,
                    'customizations' => $item['customizations'] ?? []
                ];
                $cartCount += $item['quantity'];
            }
        }

        return response()->json([
            'success' => true,
            'cart_items' => $cartItems,
            'cart_count' => $cartCount
        ]);
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'menu_item_id' => 'required|exists:menu_items,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $menuItem = MenuItem::with('restaurant')->findOrFail($request->menu_item_id);

        // Check if menu item is available
        if (!$menuItem->is_available) {
            return response()->json([
                'success' => false,
                'message' => 'This item is currently unavailable'
            ], 400);
        }

        $cart = session()->get('cart', []);

        // Check if we're adding items from different restaurants
        if (!empty($cart)) {
            $firstMenuItem = MenuItem::find($cart[0]['menu_item_id']);

            if ($firstMenuItem && $firstMenuItem->restaurant_id !== $menuItem->restaurant_id) {
                // Clear cart and add new item (auto-switch restaurant)
                $cart = [
                    [
                        'menu_item_id' => $request->menu_item_id,
                        'quantity' => $request->quantity,
                        'added_at' => now()
                    ]
                ];

                session()->put('cart', $cart);

                $cartCount = $request->quantity;

                return response()->json([
                    'success' => true,
                    'message' => 'Switched to ' . $menuItem->restaurant->name . '. Previous cart items were cleared.',
                    'cart_count' => $cartCount,
                    'restaurant_switched' => true,
                    'new_restaurant' => $menuItem->restaurant->name
                ]);
            }
        }

        // Find existing item in cart
        $itemIndex = -1;
        foreach ($cart as $index => $item) {
            if ($item['menu_item_id'] == $request->menu_item_id) {
                $itemIndex = $index;
                break;
            }
        }

        if ($itemIndex >= 0) {
            // Update quantity if item exists
            $cart[$itemIndex]['quantity'] += $request->quantity;
        } else {
            // Add new item to cart
            $cart[] = [
                'menu_item_id' => $request->menu_item_id,
                'quantity' => $request->quantity,
                'added_at' => now()
            ];
        }

        session()->put('cart', $cart);

        $cartCount = 0;
        foreach ($cart as $item) {
            $cartCount += $item['quantity'];
        }

        return response()->json([
            'success' => true,
            'message' => 'Item added to cart successfully',
            'cart_count' => $cartCount,
            'restaurant_switched' => false
        ]);
    }

    public function updateCart(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.menu_item_id' => 'required|exists:menu_items,id',
            'items.*.quantity' => 'required|integer|min:0'
        ]);

        $cart = session()->get('cart', []);

        foreach ($request->items as $itemData) {
            $itemIndex = -1;

            // Find item in cart
            foreach ($cart as $index => $item) {
                if ($item['menu_item_id'] == $itemData['menu_item_id']) {
                    $itemIndex = $index;
                    break;
                }
            }

            if ($itemIndex >= 0) {
                if ($itemData['quantity'] == 0) {
                    // Remove item if quantity is 0
                    array_splice($cart, $itemIndex, 1);
                } else {
                    // Update quantity
                    $cart[$itemIndex]['quantity'] = $itemData['quantity'];
                }
            }
        }

        session()->put('cart', $cart);

        $cartCount = 0;
        foreach ($cart as $item) {
            $cartCount += $item['quantity'];
        }

        return response()->json([
            'success' => true,
            'message' => 'Cart updated successfully',
            'cart_count' => $cartCount
        ]);
    }

    public function removeFromCart($menuItemId)
    {
        $cart = session()->get('cart', []);

        foreach ($cart as $index => $item) {
            if ($item['menu_item_id'] == $menuItemId) {
                array_splice($cart, $index, 1);
                break;
            }
        }

        session()->put('cart', $cart);

        $cartCount = 0;
        foreach ($cart as $item) {
            $cartCount += $item['quantity'];
        }

        return response()->json([
            'success' => true,
            'message' => 'Item removed from cart',
            'cart_count' => $cartCount
        ]);
    }

    public function clearCart()
    {
        session()->forget('cart');

        return response()->json([
            'success' => true,
            'message' => 'Cart cleared successfully',
            'cart_count' => 0
        ]);
    }

    // public function checkout()
    // {
    //     $cart = session()->get('cart', []);

    //     if (empty($cart)) {
    //         return redirect()->route('customer.cart')->with('error', 'Your cart is empty');
    //     }

    //     $cartItems = [];
    //     $total = 0;
    //     $restaurantId = null;

    //     foreach ($cart as $item) {
    //         $menuItem = MenuItem::with('restaurant')->find($item['menu_item_id']);
    //         if ($menuItem) {
    //             if (!$restaurantId) {
    //                 $restaurantId = $menuItem->restaurant_id;
    //             }

    //             $itemTotal = $menuItem->price * $item['quantity'];
    //             $cartItems[] = [
    //                 'menu_item' => $menuItem,
    //                 'quantity' => $item['quantity'],
    //                 'total_price' => $itemTotal,
    //                 'customizations' => $item['customizations'] ?? []
    //             ];
    //             $total += $itemTotal;
    //         }
    //     }

    //     $restaurant = Restaurant::find($restaurantId);

    //     return view('customer.checkout.index', [
    //         'title' => 'Checkout - FoodOrder',
    //         'cartItems' => $cartItems,
    //         'total' => $total,
    //         'restaurant' => $restaurant
    //     ]);
    // }

    // public function placeOrder(Request $request)
    // {
    //     // This will be implemented in the next phase
    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Order placed successfully',
    //         'order_id' => 1 // Temporary
    //     ]);
    // }


    // ======================================================================

    public function checkout()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('customer.cart')->with('error', 'Your cart is empty');
        }

        // Validate all items are still available and from the same restaurant
        $restaurantId = null;
        $cartItems = [];
        $subtotal = 0;

        foreach ($cart as $item) {
            $menuItem = MenuItem::with('restaurant')->find($item['menu_item_id']);

            if (!$menuItem || !$menuItem->is_available) {
                return redirect()->route('customer.cart')->with('error', 'Some items in your cart are no longer available');
            }

            // Check if all items are from the same restaurant
            if ($restaurantId === null) {
                $restaurantId = $menuItem->restaurant_id;
            } elseif ($restaurantId !== $menuItem->restaurant_id) {
                return redirect()->route('customer.cart')->with('error', 'All items must be from the same restaurant');
            }

            $itemTotal = $menuItem->price * $item['quantity'];
            $subtotal += $itemTotal;

            $cartItems[] = [
                'menu_item' => $menuItem,
                'quantity' => $item['quantity'],
                'total_price' => $itemTotal,
                'customizations' => $item['customizations'] ?? []
            ];
        }

        $restaurant = Restaurant::findOrFail($restaurantId);

        // Calculate totals
        $deliveryFee = $restaurant->delivery_fee ?? 5000;
        $taxRate = 0.1; // 10% tax
        $taxAmount = $subtotal * $taxRate;
        $total = $subtotal + $deliveryFee + $taxAmount;

        // Check minimum order
        $minOrder = $restaurant->min_order ?? 25000;
        if ($subtotal < $minOrder) {
            return redirect()->route('customer.cart')->with('error',
                'Minimum order for ' . $restaurant->name . ' is Rp ' . number_format($minOrder, 0, ',', '.'));
        }

        // Get user data for pre-fill
        $user = auth()->user();

        return view('customer.checkout.index', [
            'title' => 'Checkout - FoodOrder',
            'cartItems' => $cartItems,
            'restaurant' => $restaurant,
            'subtotal' => $subtotal,
            'deliveryFee' => $deliveryFee,
            'taxRate' => $taxRate,
            'taxAmount' => $taxAmount,
            'total' => $total,
            'minOrder' => $minOrder,
            'user' => $user
        ]);
    }

    public function placeOrder(Request $request)
    {
        DB::beginTransaction();

        try {
            $cart = session()->get('cart', []);

            if (empty($cart)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Your cart is empty'
                ], 400);
            }

            // Enhanced validation with payment-specific rules
            $validated = $request->validate([
                'customer_name' => 'required|string|max:255',
                'customer_phone' => 'required|string|max:20',
                'customer_address' => 'required|string|max:500',
                'delivery_notes' => 'nullable|string|max:500',
                'payment_method' => 'required|in:cash,card,digital_wallet',
                'delivery_time' => 'required|in:asap,schedule'
            ]);

            // Comprehensive cart validation
            $restaurantId = null;
            $subtotal = 0;
            $cartItemsData = [];

            foreach ($cart as $item) {
                $menuItem = MenuItem::with('restaurant')->find($item['menu_item_id']);

                if (!$menuItem) {
                    throw new \Exception('One or more items in your cart are no longer available');
                }

                if (!$menuItem->is_available) {
                    throw new \Exception($menuItem->name . ' is currently unavailable');
                }

                if ($restaurantId === null) {
                    $restaurantId = $menuItem->restaurant_id;
                } elseif ($restaurantId !== $menuItem->restaurant_id) {
                    throw new \Exception('All items must be from the same restaurant');
                }

                $itemTotal = $menuItem->price * $item['quantity'];
                $subtotal += $itemTotal;

                $cartItemsData[] = [
                    'menu_item' => $menuItem,
                    'quantity' => $item['quantity'],
                    'customizations' => $item['customizations'] ?? []
                ];
            }

            $restaurant = Restaurant::findOrFail($restaurantId);

            // Enhanced minimum order validation
            $minOrder = $restaurant->min_order ?? 25000;
            if ($subtotal < $minOrder) {
                throw new \Exception('Minimum order for ' . $restaurant->name . ' is Rp ' . number_format($minOrder, 0, ',', '.'));
            }

            // Calculate totals with restaurant-specific fees
            $deliveryFee = $restaurant->delivery_fee ?? 5000;
            $taxRate = 0.1; // 10%
            $taxAmount = $subtotal * $taxRate;
            $finalTotal = $subtotal + $deliveryFee + $taxAmount;

            // Generate unique order number
            $orderNumber = 'ORD-' . now()->format('YmdHis') . rand(100, 999);

            // Determine payment status based on method
            $paymentStatus = $request->payment_method === 'cash' ? 'pending' : 'paid';

            // Create order with enhanced data
            $order = Order::create([
                'order_number' => $orderNumber,
                'status' => 'pending',
                'total_amount' => $finalTotal,
                'subtotal' => $subtotal,
                'delivery_fee' => $deliveryFee,
                'tax_amount' => $taxAmount,
                'notes' => $request->delivery_notes,
                'customer_name' => $request->customer_name,
                'customer_phone' => $request->customer_phone,
                'customer_address' => $request->customer_address,
                'user_id' => auth()->id(),
                'restaurant_id' => $restaurantId,
                'payment_method' => $request->payment_method,
                'payment_status' => $paymentStatus,
                'delivery_time' => $request->delivery_time,
                'ordered_at' => now(),
            ]);

            // Create order items with enhanced data
            foreach ($cartItemsData as $itemData) {
                $menuItem = $itemData['menu_item'];

                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_item_id' => $menuItem->id,
                    'quantity' => $itemData['quantity'],
                    'unit_price' => $menuItem->price,
                    'total_price' => $menuItem->price * $itemData['quantity'],
                    'customizations' => $itemData['customizations']
                ]);
            }

            // Clear cart session
            session()->forget('cart');

            DB::commit();

            // Log successful order
            Log::info('Order placed successfully', [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'user_id' => auth()->id(),
                'total_amount' => $finalTotal
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Order placed successfully!',
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'redirect_url' => route('customer.orders.confirmation', $order)
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Please check your information and try again.',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Order placement failed: ' . $e->getMessage(), [
                'user_id' => auth()->id(),
                'cart_items' => $cart ?? 'empty'
            ]);

            return response()->json([
                'success' => false,
                'message' => $e->getMessage() ?: 'Failed to place order. Please try again.'
            ], 500);
        }
    }
}
