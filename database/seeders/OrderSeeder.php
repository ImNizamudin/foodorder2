<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    public function run()
    {
        DB::table('orders')->delete();

        $restaurants = Restaurant::all();
        $customers = User::where('role', 'customer')->get();

        if ($restaurants->isEmpty() || $customers->isEmpty()) {
            $this->command->info('No restaurants or customers found. Please seed them first.');
            return;
        }

        $orders = [];
        $statuses = ['pending', 'confirmed', 'preparing', 'ready', 'completed'];

        for ($i = 0; $i < 20; $i++) {
            $restaurant = $restaurants->random();
            $customer = $customers->random();
            $status = $statuses[array_rand($statuses)];

            $orderTime = now()->subDays(rand(0, 7))->subHours(rand(1, 24));

            $orders[] = [
                'order_number' => 'ORD' . rand(1000, 9999),
                'status' => $status,
                'total_amount' => 0, // Will be updated by OrderItemSeeder
                'notes' => rand(0, 1) ? 'Please make it less spicy' : null,
                'customer_name' => $customer->name,
                'customer_phone' => $customer->phone,
                'customer_address' => 'Jl. Example No. ' . rand(1, 100) . ', Jakarta',
                'user_id' => $customer->id,
                'restaurant_id' => $restaurant->id,
                'created_at' => $orderTime,
                'updated_at' => $orderTime,
            ];
        }

        DB::table('orders')->insert($orders);
        $this->command->info('Successfully seeded orders!');
    }
}
