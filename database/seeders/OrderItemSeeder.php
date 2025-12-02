<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\MenuItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderItemSeeder extends Seeder
{
    public function run()
    {
        // Clear existing order items
        DB::table('order_items')->delete();

        // Get all orders and menu items
        $orders = Order::all();
        $menuItems = MenuItem::all();

        if ($orders->isEmpty() || $menuItems->isEmpty()) {
            $this->command->info('No orders or menu items found. Please run Order and MenuItem seeders first.');
            return;
        }

        $orderItems = [];

        foreach ($orders as $order) {
            // Each order gets 1-4 random menu items
            $itemCount = rand(1, 4);
            $selectedItems = $menuItems->random($itemCount);

            foreach ($selectedItems as $menuItem) {
                $quantity = rand(1, 3);
                $unitPrice = $menuItem->price;
                $totalPrice = $unitPrice * $quantity;

                $orderItems[] = [
                    'order_id' => $order->id,
                    'menu_item_id' => $menuItem->id,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'total_price' => $totalPrice,
                    'created_at' => $order->created_at,
                    'updated_at' => $order->created_at,
                ];
            }

            // Update order total amount based on order items
            $orderTotal = collect($orderItems)
                ->where('order_id', $order->id)
                ->sum('total_price') + 12000; // Add delivery fee

            $order->update(['total_amount' => $orderTotal]);
        }

        // Insert all order items
        DB::table('order_items')->insert($orderItems);

        $this->command->info('Successfully seeded order items with realistic data!');
    }
}
