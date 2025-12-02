<?php

namespace App\Helpers;

use App\Models\Order;
use App\Models\MenuItem;

class OwnerHelper
{
    /**
     * Get pending orders count for restaurant
     */
    public static function getPendingOrdersCount($restaurantId)
    {
        return Order::where('restaurant_id', $restaurantId)
            ->whereIn('status', ['pending', 'confirmed', 'preparing', 'ready'])
            ->where('status', '!=', 'completed')
            ->where('status', '!=', 'cancelled')
            ->count();
    }

    /**
     * Get menu items count for restaurant
     */
    public static function getMenuItemsCount($restaurantId)
    {
        return MenuItem::where('restaurant_id', $restaurantId)->count();
    }

    /**
     * Get today's revenue for restaurant
     */
    public static function getTodayRevenue($restaurantId)
    {
        return Order::where('restaurant_id', $restaurantId)
            ->where('status', 'completed')
            ->whereDate('created_at', today())
            ->sum('total_amount');
    }

    /**
     * Get active orders count for restaurant
     */
    public static function getActiveOrdersCount($restaurantId)
    {
        return Order::where('restaurant_id', $restaurantId)
            ->whereIn('status', ['pending', 'confirmed', 'preparing', 'ready'])
            ->count();
    }

    /**
     * Get pending notifications count
     */
    public static function getPendingNotifications($restaurantId)
    {
        return Order::where('restaurant_id', $restaurantId)
            ->whereIn('status', ['pending', 'confirmed'])
            ->count();
    }
}