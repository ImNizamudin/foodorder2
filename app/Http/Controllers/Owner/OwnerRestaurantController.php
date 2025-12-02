<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\Order;
use App\Models\MenuItem;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OwnerRestaurantController extends Controller
{
    public function create()
    {
        // ✅ Check if user already has a restaurant
        $existingRestaurant = Restaurant::where('user_id', Auth::id())->first();

        if ($existingRestaurant) {
            return redirect()->route('owner.dashboard')
                ->with('info', 'You already have a restaurant setup. You can edit it from restaurant settings.');
        }

        return view('owner.restaurants.create', [
            'title' => 'Create Restaurant'
        ]);
    }

    public function store(Request $request)
    {
        // ✅ Check if user already has a restaurant
        $existingRestaurant = Restaurant::where('user_id', Auth::id())->first();

        if ($existingRestaurant) {
            return redirect()->route('owner.dashboard')
                ->with('error', 'You can only have one restaurant per account.');
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:500'],
            'address' => ['required', 'string'],
            'phone' => ['required', 'string', 'max:15'],
            'email' => ['nullable', 'email'],
            'logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'], // 2MB max
            'cover_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:5120'], // 5MB max
        ]);

        try {
            $restaurantData = [
                'name' => $request->name,
                'description' => $request->description,
                'address' => $request->address,
                'phone' => $request->phone,
                'email' => $request->email,
                'user_id' => Auth::id(),
                'status' => 'active',
            ];

            // Handle logo upload
            if ($request->hasFile('logo')) {
                $logoPath = $request->file('logo')->store('restaurants/logos', 'public');
                $restaurantData['logo'] = $logoPath;
            }

            // Handle cover image upload
            if ($request->hasFile('cover_image')) {
                $coverPath = $request->file('cover_image')->store('restaurants/covers', 'public');
                $restaurantData['cover_image'] = $coverPath;
            }

            Restaurant::create($restaurantData);

            return redirect()->route('owner.dashboard')
                ->with('success', '🎉 Restaurant created successfully! You can now add menu items and start accepting orders.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to create restaurant. Please try again.')
                ->withInput();
        }
    }

    public function edit()
    {
        $restaurant = Restaurant::where('user_id', Auth::id())->firstOrFail();

        // // Get comprehensive restaurant statistics
        // $stats = $this->getRestaurantStatistics($restaurant);
        $stats = [
            'total_orders' => Order::where('restaurant_id', $restaurant->id)->count(),
            'total_revenue' => Order::where('restaurant_id', $restaurant->id)
                ->where('status', 'completed')
                ->sum('total_amount'),
        ];

        return view('owner.restaurants.edit', [
            'title' => 'Edit Restaurant',
            'restaurant' => $restaurant,
            'stats' => $stats
        ]);
    }

    public function update(Request $request)
    {
        $restaurant = Restaurant::where('user_id', Auth::id())->firstOrFail();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:500'],
            'address' => ['required', 'string'],
            'phone' => ['required', 'string', 'max:15'],
            'email' => ['nullable', 'email'],
            'logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'cover_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:5120'],
            'remove_logo' => ['nullable', 'boolean'],
            'remove_cover' => ['nullable', 'boolean'],
        ]);

        try {
            $updateData = [
                'name' => $request->name,
                'description' => $request->description,
                'address' => $request->address,
                'phone' => $request->phone,
                'email' => $request->email,
            ];

            // Handle logo upload/removal
            if ($request->has('remove_logo') && $request->remove_logo) {
                // Remove existing logo
                if ($restaurant->logo) {
                    Storage::disk('public')->delete($restaurant->logo);
                    $updateData['logo'] = null;
                }
            } elseif ($request->hasFile('logo')) {
                // Remove old logo if exists
                if ($restaurant->logo) {
                    Storage::disk('public')->delete($restaurant->logo);
                }
                // Upload new logo
                $logoPath = $request->file('logo')->store('restaurants/logos', 'public');
                $updateData['logo'] = $logoPath;
            }

            // Handle cover image upload/removal
            if ($request->has('remove_cover') && $request->remove_cover) {
                // Remove existing cover
                if ($restaurant->cover_image) {
                    Storage::disk('public')->delete($restaurant->cover_image);
                    $updateData['cover_image'] = null;
                }
            } elseif ($request->hasFile('cover_image')) {
                // Remove old cover if exists
                if ($restaurant->cover_image) {
                    Storage::disk('public')->delete($restaurant->cover_image);
                }
                // Upload new cover
                $coverPath = $request->file('cover_image')->store('restaurants/covers', 'public');
                $updateData['cover_image'] = $coverPath;
            }

            $restaurant->update($updateData);

            return redirect()->route('owner.restaurants.edit')
                ->with('success', '✅ Restaurant updated successfully!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to update restaurant. Please try again.')
                ->withInput();
        }
    }

    public function removeImage(Request $request, $type)
    {
        $restaurant = Restaurant::where('user_id', Auth::id())->firstOrFail();

        try {
            if ($type === 'logo' && $restaurant->logo) {
                Storage::disk('public')->delete($restaurant->logo);
                $restaurant->update(['logo' => null]);
                return response()->json(['success' => true, 'message' => 'Logo removed successfully']);
            } elseif ($type === 'cover' && $restaurant->cover_image) {
                Storage::disk('public')->delete($restaurant->cover_image);
                $restaurant->update(['cover_image' => null]);
                return response()->json(['success' => true, 'message' => 'Cover image removed successfully']);
            }

            return response()->json(['success' => false, 'message' => 'No image to remove'], 400);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to remove image'], 500);
        }
    }

    public function toggleStatus(Request $request)
    {
        $restaurant = Restaurant::where('user_id', Auth::id())->firstOrFail();

        $request->validate([
            'status' => ['required', 'in:active,inactive']
        ]);

        try {
            $oldStatus = $restaurant->status;
            $newStatus = $request->status;

            $restaurant->update(['status' => $newStatus]);

            $message = $newStatus === 'active'
                ? 'Restaurant activated successfully! Your restaurant is now accepting orders.'
                : 'Restaurant deactivated successfully! Your restaurant will not receive new orders.';

            return response()->json([
                'success' => true,
                'message' => $message,
                'new_status' => $newStatus
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update restaurant status.'
            ], 500);
        }
    }

    // private function getRestaurantStatistics($restaurant)
    // {
    //     // Total orders
    //     $totalOrders = Order::where('restaurant_id', $restaurant->id)->count();

    //     // Total revenue
    //     $totalRevenue = Order::where('restaurant_id', $restaurant->id)
    //         ->where('status', 'completed')
    //         ->sum('total_amount');

    //     // Average rating
    //     $avgRating = Review::where('restaurant_id', $restaurant->id)
    //         ->avg('rating') ?? 4.7;
    //     $avgRating = round($avgRating, 1);

    //     // Success rate (completed orders vs total orders)
    //     $completedOrders = Order::where('restaurant_id', $restaurant->id)
    //         ->where('status', 'completed')
    //         ->count();

    //     $successRate = $totalOrders > 0 ? round(($completedOrders / $totalOrders) * 100) : 100;

    //     // Menu items count
    //     $menuItemsCount = MenuItem::where('restaurant_id', $restaurant->id)->count();

    //     // Today's revenue
    //     $todayRevenue = Order::where('restaurant_id', $restaurant->id)
    //         ->where('status', 'completed')
    //         ->whereDate('created_at', today())
    //         ->sum('total_amount');

    //     return [
    //         'total_orders' => $totalOrders,
    //         'total_revenue' => $totalRevenue,
    //         'avg_rating' => $avgRating,
    //         'success_rate' => $successRate,
    //         'menu_items_count' => $menuItemsCount,
    //         'today_revenue' => $todayRevenue,
    //     ];
    // }
}
