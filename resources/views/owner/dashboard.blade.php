@extends('layouts.owner')

@section('title', 'Restaurant Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Welcome Card -->
    <div class="bg-gradient-to-r from-accent-amber to-orange-500 rounded-2xl p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold">Welcome back, {{ auth()->user()->name }}! 🎯</h1>
                <p class="text-orange-100 mt-1">{{ $restaurant->name }} is performing great today</p>
            </div>
            <div class="flex items-center space-x-4 text-orange-100">
                <div class="text-center">
                    <p class="text-sm">Restaurant Status</p>
                    <p class="font-semibold capitalize">{{ $restaurant->status }}</p>
                </div>
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                    <i class='bx bx-check-shield text-xl'></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Today's Orders -->
        <div class="stat-card bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Today's Orders</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['today_orders'] }}</p>
                    <div class="flex items-center mt-2">
                        @if($stats['growth'] > 0)
                        <i class='bx bx-up-arrow-alt text-green-500 text-sm'></i>
                        <span class="text-green-600 text-sm font-medium ml-1">+{{ $stats['growth'] }}%</span>
                        @elseif($stats['growth'] < 0)
                        <i class='bx bx-down-arrow-alt text-red-500 text-sm'></i>
                        <span class="text-red-600 text-sm font-medium ml-1">{{ $stats['growth'] }}%</span>
                        @else
                        <i class='bx bx-minus text-gray-500 text-sm'></i>
                        <span class="text-gray-600 text-sm font-medium ml-1">No change</span>
                        @endif
                    </div>
                </div>
                <div class="w-14 h-14 bg-orange-100 rounded-2xl flex items-center justify-center">
                    <i class='bx bx-cart-alt text-2xl text-orange-600'></i>
                </div>
            </div>
        </div>

        <!-- Pending Orders -->
        <div class="stat-card bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Pending Orders</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['pending_orders'] }}</p>
                    <div class="flex items-center mt-2">
                        <i class='bx bx-time text-yellow-500 text-sm'></i>
                        <span class="text-yellow-600 text-sm font-medium ml-1">Need attention</span>
                    </div>
                </div>
                <div class="w-14 h-14 bg-yellow-100 rounded-2xl flex items-center justify-center">
                    <i class='bx bx-time-five text-2xl text-yellow-600'></i>
                </div>
            </div>
        </div>

        <!-- Preparing Orders -->
        <div class="stat-card bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Preparing</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['preparing_orders'] }}</p>
                    <div class="flex items-center mt-2">
                        <i class='bx bx-bowl-hot text-orange-500 text-sm'></i>
                        <span class="text-orange-600 text-sm font-medium ml-1">In kitchen</span>
                    </div>
                </div>
                <div class="w-14 h-14 bg-orange-100 rounded-2xl flex items-center justify-center">
                    <i class='bx bx-bowl-hot text-2xl text-orange-600'></i>
                </div>
            </div>
        </div>

        <!-- Today's Revenue -->
        <div class="stat-card bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Today's Revenue</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">Rp {{ number_format($stats['today_revenue'], 0, ',', '.') }}</p>
                    <div class="flex items-center mt-2">
                        @if($stats['revenue_growth'] > 0)
                        <i class='bx bx-up-arrow-alt text-green-500 text-sm'></i>
                        <span class="text-green-600 text-sm font-medium ml-1">+{{ $stats['revenue_growth'] }}%</span>
                        @elseif($stats['revenue_growth'] < 0)
                        <i class='bx bx-down-arrow-alt text-red-500 text-sm'></i>
                        <span class="text-red-600 text-sm font-medium ml-1">{{ $stats['revenue_growth'] }}%</span>
                        @else
                        <i class='bx bx-minus text-gray-500 text-sm'></i>
                        <span class="text-gray-600 text-sm font-medium ml-1">No change</span>
                        @endif
                    </div>
                </div>
                <div class="w-14 h-14 bg-green-100 rounded-2xl flex items-center justify-center">
                    <i class='bx bx-credit-card text-2xl text-green-600'></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Two Column Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Orders -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-semibold text-gray-900">Recent Orders</h2>
                <a href="{{ route('owner.orders.index') }}" class="text-primary-600 hover:text-primary-700 text-sm font-medium">View All</a>
            </div>

            <div class="space-y-4">
                @forelse($recentOrders as $order)
                <div class="flex items-center justify-between p-4 rounded-xl border border-gray-100 hover:bg-gray-50 transition">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-gradient-to-r from-primary-500 to-primary-600 rounded-xl flex items-center justify-center">
                            <i class='bx bx-receipt text-white text-lg'></i>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">{{ $order->order_number }}</p>
                            <p class="text-gray-600 text-sm">
                                @foreach($order->orderItems->take(2) as $item)
                                    {{ $item->menuItem->name ?? 'Item' }}{{ !$loop->last ? ', ' : '' }}
                                @endforeach
                                @if($order->orderItems->count() > 2)
                                ... +{{ $order->orderItems->count() - 2 }} more
                                @endif
                            </p>
                            <p class="text-gray-400 text-xs">{{ $order->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    <div>
                        @php
                            $statusConfig = [
                                'pending' => ['color' => 'yellow', 'icon' => '⏳'],
                                'confirmed' => ['color' => 'blue', 'icon' => '✅'],
                                'preparing' => ['color' => 'orange', 'icon' => '👨‍🍳'],
                                'ready' => ['color' => 'green', 'icon' => '📦'],
                                'completed' => ['color' => 'gray', 'icon' => '🎉'],
                                'cancelled' => ['color' => 'red', 'icon' => '❌']
                            ];
                            $currentStatus = $statusConfig[$order->status] ?? ['color' => 'gray', 'icon' => '📋'];
                        @endphp
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                            bg-{{ $currentStatus['color'] }}-100 text-{{ $currentStatus['color'] }}-800 border border-{{ $currentStatus['color'] }}-200">
                            {{ $currentStatus['icon'] }} {{ ucfirst($order->status) }}
                        </span>
                    </div>
                </div>
                @empty
                <div class="text-center py-8">
                    <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <i class='bx bx-receipt text-2xl text-gray-400'></i>
                    </div>
                    <h4 class="text-lg font-medium text-gray-900 mb-2">No Orders Yet</h4>
                    <p class="text-gray-600">Your orders will appear here once customers start ordering.</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Quick Actions & Popular Items -->
        <div class="space-y-6">
            <!-- Quick Actions -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h2>

                <div class="grid grid-cols-2 gap-3">
                    <a href="{{ route('owner.menu-items.create') }}" class="p-3 rounded-xl bg-primary-50 border border-primary-200 hover:bg-primary-100 transition text-center group">
                        <i class='bx bx-plus text-xl text-primary-600 mb-2 block'></i>
                        <span class="text-sm font-medium text-primary-700">Add Menu</span>
                    </a>

                    <a href="{{ route('owner.orders.index') }}" class="p-3 rounded-xl bg-blue-50 border border-blue-200 hover:bg-blue-100 transition text-center group">
                        <i class='bx bx-receipt text-xl text-blue-600 mb-2 block'></i>
                        <span class="text-sm font-medium text-blue-700">View Orders</span>
                    </a>

                    <a href="{{ route('owner.restaurants.edit', $restaurant) }}" class="p-3 rounded-xl bg-orange-50 border border-orange-200 hover:bg-orange-100 transition text-center group">
                        <i class='bx bx-cog text-xl text-orange-600 mb-2 block'></i>
                        <span class="text-sm font-medium text-orange-700">Settings</span>
                    </a>

                    <a href="{{ route('owner.analytics.index') }}" class="p-3 rounded-xl bg-purple-50 border border-purple-200 hover:bg-purple-100 transition text-center group">
                        <i class='bx bx-bar-chart text-xl text-purple-600 mb-2 block'></i>
                        <span class="text-sm font-medium text-purple-700">Reports</span>
                    </a>
                </div>
            </div>

            <!-- Popular Items -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Popular Items</h2>

                <div class="space-y-3">
                    @forelse($popularItems as $item)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center">
                                <i class='bx bx-star text-white text-sm'></i>
                            </div>
                            <span class="text-gray-700 font-medium">{{ $item->name }}</span>
                        </div>
                        <span class="text-gray-900 font-semibold">{{ $item->orders_count }} orders</span>
                    </div>
                    @empty
                    <div class="text-center py-4">
                        <i class='bx bx-food-menu text-2xl text-gray-300 mb-2'></i>
                        <p class="text-gray-500 text-sm">No popular items yet</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Restaurant Performance -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
        <h2 class="text-lg font-semibold text-gray-900 mb-6">{{ $restaurant->name }} Performance</h2>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <div class="text-center p-4 rounded-xl bg-green-50 border border-green-100">
                <div class="w-12 h-12 bg-green-500 rounded-2xl flex items-center justify-center mx-auto mb-3">
                    <i class='bx bx-timer text-2xl text-white'></i>
                </div>
                <p class="text-2xl font-bold text-gray-900">18min</p>
                <p class="text-gray-600 text-sm mt-1">Avg Prep Time</p>
            </div>

            <div class="text-center p-4 rounded-xl bg-blue-50 border border-blue-100">
                <div class="w-12 h-12 bg-blue-500 rounded-2xl flex items-center justify-center mx-auto mb-3">
                    <i class='bx bx-star text-2xl text-white'></i>
                </div>
                <p class="text-2xl font-bold text-gray-900">4.7/5</p>
                <p class="text-gray-600 text-sm mt-1">Customer Rating</p>
            </div>

            <div class="text-center p-4 rounded-xl bg-orange-50 border border-orange-100">
                <div class="w-12 h-12 bg-orange-500 rounded-2xl flex items-center justify-center mx-auto mb-3">
                    <i class='bx bx-repeat text-2xl text-white'></i>
                </div>
                <p class="text-2xl font-bold text-gray-900">72%</p>
                <p class="text-gray-600 text-sm mt-1">Repeat Customers</p>
            </div>

            <div class="text-center p-4 rounded-xl bg-purple-50 border border-purple-100">
                <div class="w-12 h-12 bg-purple-500 rounded-2xl flex items-center justify-center mx-auto mb-3">
                    <i class='bx bx-trending-up text-2xl text-white'></i>
                </div>
                <p class="text-2xl font-bold text-gray-900">+{{ $stats['growth'] }}%</p>
                <p class="text-gray-600 text-sm mt-1">Order Growth</p>
            </div>
        </div>
    </div>
</div>
@endsection
