@extends('layouts.owner')

@section('title', 'Order Management')

@section('content')
<div class="space-y-6">
    <!-- Header with Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="stat-card bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Active Orders Today</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['active_orders_today'] }}</p>
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
                    <i class='bx bx-time-five text-2xl text-orange-600'></i>
                </div>
            </div>
        </div>

        <div class="stat-card bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Pending</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['pending_orders'] }}</p>
                    <div class="flex items-center mt-2">
                        <i class='bx bx-time text-yellow-500 text-sm'></i>
                        <span class="text-yellow-600 text-sm font-medium ml-1">Needs action</span>
                    </div>
                </div>
                <div class="w-14 h-14 bg-yellow-100 rounded-2xl flex items-center justify-center">
                    <i class='bx bx-time-five text-2xl text-yellow-600'></i>
                </div>
            </div>
        </div>

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
                <div class="w-14 h-14 bg-primary-100 rounded-2xl flex items-center justify-center">
                    <i class='bx bx-cart-alt text-2xl text-primary-600'></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters & Search -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
        <form action="{{ route('owner.orders.index') }}" method="GET" id="filterForm">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="flex flex-col md:flex-row md:items-center space-y-4 md:space-y-0 md:space-x-4">
                    <!-- Search -->
                    <div class="relative">
                        <i class='bx bx-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400'></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search orders..."
                               class="pl-10 pr-4 py-2 border border-gray-300 rounded-xl focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition w-full md:w-64">
                    </div>

                    <!-- Status Filter -->
                    <select name="status" class="px-4 py-2 border border-gray-300 rounded-xl focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition">
                        <option value="all" {{ request('status', 'all') == 'all' ? 'selected' : '' }}>All Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="preparing" {{ request('status') == 'preparing' ? 'selected' : '' }}>Preparing</option>
                        <option value="ready" {{ request('status') == 'ready' ? 'selected' : '' }}>Ready</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>

                    <!-- Date Filter -->
                    <select name="date_filter" class="px-4 py-2 border border-gray-300 rounded-xl focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition">
                        <option value="all" {{ request('date_filter', 'all') == 'all' ? 'selected' : '' }}>All Time</option>
                        <option value="today" {{ request('date_filter') == 'today' ? 'selected' : '' }}>Today</option>
                        <option value="yesterday" {{ request('date_filter') == 'yesterday' ? 'selected' : '' }}>Yesterday</option>
                        <option value="week" {{ request('date_filter') == 'week' ? 'selected' : '' }}>This Week</option>
                        <option value="month" {{ request('date_filter') == 'month' ? 'selected' : '' }}>This Month</option>
                    </select>
                </div>

                <div class="flex items-center space-x-2">
                    <!-- Refresh Button -->
                    <button type="button" id="refreshBtn" class="px-4 py-2 border border-gray-300 rounded-xl hover:bg-gray-50 transition flex items-center space-x-2">
                        <i class='bx bx-refresh'></i>
                        <span>Refresh</span>
                    </button>

                    <button type="button" id="clearFilters" class="px-4 py-2 border border-gray-300 rounded-xl hover:bg-gray-50 transition flex items-center space-x-2">
                        <i class='bx bx-reset'></i>
                        <span>Clear</span>
                    </button>
                    <button type="submit" class="px-4 py-2 bg-primary-500 text-white rounded-xl hover:bg-primary-600 transition flex items-center space-x-2">
                        <i class='bx bx-filter'></i>
                        <span>Apply Filters</span>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Orders Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <!-- Table Header -->
        <div class="border-b border-gray-200">
            <div class="grid grid-cols-12 gap-4 px-6 py-4 bg-gray-50">
                <div class="col-span-3 font-semibold text-gray-900">Order & Customer</div>
                <div class="col-span-2 font-semibold text-gray-900">Items</div>
                <div class="col-span-2 font-semibold text-gray-900">Total</div>
                <div class="col-span-2 font-semibold text-gray-900">Time</div>
                <div class="col-span-2 font-semibold text-gray-900">Status</div>
                <div class="col-span-1 font-semibold text-gray-900 text-center">Actions</div>
            </div>
        </div>

        <!-- Table Body -->
        <div class="divide-y divide-gray-100" id="ordersContainer">
            @forelse($orders as $order)
            <div class="grid grid-cols-12 gap-4 px-6 py-4 hover:bg-gray-50 transition order-item"
                 data-status="{{ $order->status }}"
                 data-date="{{ $order->created_at->format('Y-m-d') }}">
                <!-- Order & Customer Info -->
                <div class="col-span-3">
                    <div class="flex items-start space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-r from-primary-500 to-primary-600 rounded-xl flex items-center justify-center">
                            <i class='bx bx-receipt text-white'></i>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center space-x-2 mb-1">
                                <p class="font-semibold text-gray-900">{{ $order->order_number }}</p>
                            </div>
                            <div class="space-y-1">
                                <p class="text-sm text-gray-700 flex items-center space-x-1">
                                    <i class='bx bx-user text-gray-400'></i>
                                    <span>{{ $order->user->name }}</span>
                                </p>
                                <p class="text-xs text-gray-500 flex items-center space-x-1">
                                    <i class='bx bx-phone text-gray-400'></i>
                                    <span>{{ $order->user->phone ?? 'No phone' }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="col-span-2">
                    <div class="space-y-1">
                        @foreach($order->orderItems->take(2) as $item)
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-700 truncate">{{ $item->menuItem->name }}</span>
                            <span class="text-gray-500 font-medium">x{{ $item->quantity }}</span>
                        </div>
                        @endforeach
                        @if($order->orderItems->count() > 2)
                        <p class="text-xs text-gray-500">+{{ $order->orderItems->count() - 2 }} more items</p>
                        @endif
                    </div>
                </div>

                <!-- Total Amount -->
                <div class="col-span-2 flex items-center">
                    <span class="font-semibold text-green-600">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                </div>

                <!-- Time Column -->
                <div class="col-span-2 flex items-center">
                    <div class="text-sm">
                        <p class="font-medium text-gray-900">{{ $order->created_at->format('H:i') }}</p>
                        <p class="text-xs text-gray-500">{{ $order->created_at->format('M j, Y') }}</p>
                    </div>
                </div>

                <!-- Status Column -->
                <div class="col-span-2 flex items-center">
                    @php
                        $statusConfig = [
                            'pending' => ['color' => 'yellow', 'icon' => '⏳', 'text_color' => 'yellow-800'],
                            'confirmed' => ['color' => 'blue', 'icon' => '✅', 'text_color' => 'blue-800'],
                            'preparing' => ['color' => 'orange', 'icon' => '👨‍🍳', 'text_color' => 'orange-800'],
                            'ready' => ['color' => 'green', 'icon' => '📦', 'text_color' => 'green-800'],
                            'completed' => ['color' => 'gray', 'icon' => '🎉', 'text_color' => 'gray-800'],
                            'cancelled' => ['color' => 'red', 'icon' => '❌', 'text_color' => 'red-800']
                        ];
                        $currentStatus = $statusConfig[$order->status] ?? ['color' => 'gray', 'icon' => '📋', 'text_color' => 'gray-800'];
                    @endphp
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium capitalize
                        bg-{{ $currentStatus['color'] }}-100 text-{{ $currentStatus['text_color'] }} border border-{{ $currentStatus['color'] }}-200">
                        {{ $currentStatus['icon'] }} {{ $order->status }}
                    </span>
                </div>

                <!-- Actions -->
                <div class="col-span-1 flex items-center justify-center space-x-2">
                    <!-- View Details -->
                    <a href="{{ route('owner.orders.show', $order) }}"
                       class="text-gray-400 hover:text-primary-600 transition tooltip"
                       title="View Details">
                        <i class='bx bx-show text-lg'></i>
                    </a>

                    <!-- Print Receipt -->
                    <a href="{{ route('owner.orders.receipt', $order) }}" target="_blank"
                       class="text-gray-400 hover:text-gray-600 transition tooltip"
                       title="Print Receipt">
                        <i class='bx bx-printer text-lg'></i>
                    </a>

                    <!-- Quick Status Update -->
                    @if(in_array($order->status, ['pending', 'confirmed', 'preparing', 'ready']))
                    <div class="relative group">
                        <button class="text-gray-400 hover:text-green-600 transition tooltip" title="Update Status">
                            <i class='bx bx-edit text-lg'></i>
                        </button>
                        <div class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-200 py-2 z-10 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                            @if($order->status == 'pending')
                            <form action="{{ route('owner.orders.status', $order) }}" method="POST">
                                @csrf @method('PUT')
                                <input type="hidden" name="status" value="confirmed">
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-blue-600 hover:bg-blue-50 flex items-center space-x-2">
                                    <i class='bx bx-check'></i>
                                    <span>Confirm Order</span>
                                </button>
                            </form>
                            @endif

                            @if($order->status == 'confirmed')
                            <form action="{{ route('owner.orders.status', $order) }}" method="POST">
                                @csrf @method('PUT')
                                <input type="hidden" name="status" value="preparing">
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-orange-600 hover:bg-orange-50 flex items-center space-x-2">
                                    <i class='bx bx-bowl-hot'></i>
                                    <span>Start Preparing</span>
                                </button>
                            </form>
                            @endif

                            @if($order->status == 'preparing')
                            <form action="{{ route('owner.orders.status', $order) }}" method="POST">
                                @csrf @method('PUT')
                                <input type="hidden" name="status" value="ready">
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-green-600 hover:bg-green-50 flex items-center space-x-2">
                                    <i class='bx bx-check-double'></i>
                                    <span>Mark Ready</span>
                                </button>
                            </form>
                            @endif

                            @if($order->status == 'ready')
                            <form action="{{ route('owner.orders.status', $order) }}" method="POST">
                                @csrf @method('PUT')
                                <input type="hidden" name="status" value="completed">
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-600 hover:bg-gray-50 flex items-center space-x-2">
                                    <i class='bx bx-check-circle'></i>
                                    <span>Complete Order</span>
                                </button>
                            </form>
                            @endif

                            <!-- Cancel Order -->
                            @if(!in_array($order->status, ['completed', 'cancelled']))
                            <div class="border-t border-gray-200 mt-2 pt-2">
                                <form action="{{ route('owner.orders.status', $order) }}" method="POST" onsubmit="return confirm('Cancel this order?')">
                                    @csrf @method('PUT')
                                    <input type="hidden" name="status" value="cancelled">
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 flex items-center space-x-2">
                                        <i class='bx bx-x'></i>
                                        <span>Cancel Order</span>
                                    </button>
                                </form>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @empty
            <!-- Empty State -->
            <div class="px-6 py-12 text-center col-span-12">
                <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class='bx bx-receipt text-2xl text-gray-400'></i>
                </div>
                <h4 class="text-lg font-medium text-gray-900 mb-2">No Orders Found</h4>
                <p class="text-gray-600 mb-6">No orders match your current filters.</p>
                <button id="clearAllFilters" class="px-4 py-2 bg-primary-500 text-white rounded-xl hover:bg-primary-600 transition">
                    Clear Filters
                </button>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($orders->hasPages())
        <div class="border-t border-gray-200 px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-700">
                    Showing {{ $orders->firstItem() }} to {{ $orders->lastItem() }} of {{ $orders->total() }} results
                </div>
                <div class="flex space-x-2">
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<style>
    .tooltip:hover::after {
        content: attr(title);
        position: absolute;
        bottom: -30px;
        left: 50%;
        transform: translateX(-50%);
        background: #1f2937;
        color: white;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        white-space: nowrap;
        z-index: 1000;
    }

    .stat-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Refresh button functionality
        const refreshBtn = document.getElementById('refreshBtn');
        if (refreshBtn) {
            refreshBtn.addEventListener('click', function() {
                // Show loading state
                refreshBtn.disabled = true;
                refreshBtn.innerHTML = '<i class="bx bx-loader-alt bx-spin"></i><span>Refreshing...</span>';

                // Reload the page after a short delay to show loading state
                setTimeout(() => {
                    window.location.reload();
                }, 500);
            });
        }

        // Clear filters functionality
        const clearFilters = document.getElementById('clearFilters');
        const clearAllFilters = document.getElementById('clearAllFilters');

        function clearAllFiltersHandler() {
            // Reset form values
            const form = document.getElementById('filterForm');
            form.reset();

            // Submit the form to apply cleared filters
            form.submit();
        }

        if (clearFilters) {
            clearFilters.addEventListener('click', clearAllFiltersHandler);
        }

        if (clearAllFilters) {
            clearAllFilters.addEventListener('click', clearAllFiltersHandler);
        }

        // Add loading state to form submission
        const filterForm = document.getElementById('filterForm');
        if (filterForm) {
            filterForm.addEventListener('submit', function() {
                const submitBtn = this.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="bx bx-loader-alt bx-spin"></i><span>Applying...</span>';
                }
            });
        }

        // Auto-highlight new active orders (you can implement WebSocket/Livewire later)
        console.log('Active orders are highlighted with amber background and pulse animation');
    });
</script>
@endsection
