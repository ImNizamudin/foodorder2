@extends('layouts.owner')

@section('title', 'Order ' . $order->order_number)

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <a href="{{ route('owner.orders.index') }}" class="text-gray-400 hover:text-gray-600 transition">
                <i class='bx bx-arrow-back text-2xl'></i>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Order {{ $order->order_number }}</h1>
                <p class="text-gray-600">{{ $order->created_at->format('M j, Y \\a\\t H:i') }}</p>
            </div>
        </div>
        <div class="flex items-center space-x-3">
            @php
                $statusConfig = [
                    'pending' => ['color' => 'yellow', 'icon' => '⏳'],
                    'confirmed' => ['color' => 'blue', 'icon' => '✅'],
                    'preparing' => ['color' => 'orange', 'icon' => '👨‍🍳'],
                    'ready' => ['color' => 'green', 'icon' => '📦'],
                    'completed' => ['color' => 'gray', 'icon' => '🎉'],
                    'cancelled' => ['color' => 'red', 'icon' => '❌']
                ];
                $currentStatus = $statusConfig[$order->status];
            @endphp
            <span class="px-4 py-2 rounded-full text-sm font-medium capitalize border
                bg-{{ $currentStatus['color'] }}-100 text-{{ $currentStatus['color'] }}-800 border-{{ $currentStatus['color'] }}-200">
                {{ $currentStatus['icon'] }} {{ $order->status }}
            </span>
            <!-- Fixed Print Button -->
            <a href="{{ route('owner.orders.receipt', $order) }}" target="_blank"
               class="px-4 py-2 border border-gray-300 rounded-xl hover:bg-gray-50 transition flex items-center space-x-2">
                <i class='bx bx-printer'></i>
                <span>Print</span>
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column - Order Details -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Compact Order Timeline -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class='bx bx-time-five mr-2'></i>
                        Order Progress
                    </h3>
                    <div class="text-sm text-gray-600">
                        @if($order->status == 'preparing')
                        Est. 10-15 min
                        @elseif($order->status == 'confirmed')
                        Est. 15-25 min
                        @endif
                    </div>
                </div>

                <!-- Compact Timeline -->
                <div class="flex items-center justify-between relative mb-4">
                    <!-- Progress Line -->
                    <div class="absolute top-3 left-4 right-4 h-1 bg-gray-200 rounded">
                        @php
                            $steps = ['pending', 'confirmed', 'preparing', 'ready', 'completed'];
                            $currentIndex = array_search($order->status, $steps);
                            $progressWidth = ($currentIndex / (count($steps) - 1)) * 100;
                        @endphp
                        <div class="h-1 bg-green-500 rounded transition-all duration-500" style="width: {{ $progressWidth }}%"></div>
                    </div>

                    @foreach($steps as $step)
                        @php
                            $stepIndex = array_search($step, $steps);
                            $isCompleted = $stepIndex <= $currentIndex;
                            $isActive = $order->status == $step;
                            $stepIcons = ['⏳', '✅', '👨‍🍳', '📦', '🎉'];
                        @endphp

                        <div class="flex flex-col items-center relative z-10">
                            <div class="w-6 h-6 rounded-full flex items-center justify-center mb-2 text-xs font-medium
                                {{ $isCompleted ? 'bg-green-500 text-white shadow-md' : 'bg-white border-2 border-gray-300 text-gray-400' }}
                                {{ $isActive ? '!bg-' . $statusConfig[$step]['color'] . '-500 !text-white ring-2 ring-' . $statusConfig[$step]['color'] . '-200' : '' }}">
                                {{ $isCompleted ? '✓' : $stepIcons[$stepIndex] }}
                            </div>
                            <span class="text-xs font-medium {{ $isCompleted || $isActive ? 'text-gray-900' : 'text-gray-400' }}">
                                {{ ucfirst($step) }}
                            </span>
                        </div>
                    @endforeach
                </div>

                <!-- Status Description -->
                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-{{ $currentStatus['color'] }}-100 rounded-lg flex items-center justify-center">
                            <span class="text-{{ $currentStatus['color'] }}-600 text-sm">
                                {{ $currentStatus['icon'] }}
                            </span>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900 capitalize">{{ $order->status }}</p>
                            <p class="text-xs text-gray-600">
                                @switch($order->status)
                                    @case('pending') Waiting for restaurant confirmation @break
                                    @case('confirmed') Order confirmed • Est. preparation: 15-25 min @break
                                    @case('preparing') Kitchen is cooking • Ready in: 10-15 min @break
                                    @case('ready') Order ready for pickup/delivery @break
                                    @case('completed') Order completed successfully @break
                                @endswitch
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Items - Compact -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class='bx bx-food-menu mr-2'></i>
                        Order Items
                    </h3>
                    <span class="text-sm text-gray-600">{{ $order->orderItems->count() }} items</span>
                </div>

                <div class="space-y-3">
                    @foreach($order->orderItems as $item)
                    <div class="flex items-center justify-between p-3 border border-gray-100 rounded-xl hover:bg-gray-50 transition">
                        <div class="flex items-center space-x-3 flex-1 min-w-0">
                            <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                @if($item->menuItem->image)
                                    <img src="{{ asset('storage/' . $item->menuItem->image) }}" alt="{{ $item->menuItem->name }}"
                                         class="w-10 h-10 rounded-lg object-cover">
                                @else
                                    <i class='bx bx-food-menu text-gray-400'></i>
                                @endif
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="font-semibold text-gray-900 truncate">{{ $item->menuItem->name }}</p>
                                <p class="text-gray-600 text-xs">
                                    {{ $item->menuItem->category->name ?? 'Uncategorized' }}
                                    @if($item->special_instructions)
                                    • <span class="text-orange-600">"{{ Str::limit($item->special_instructions, 30) }}"</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="text-right flex-shrink-0 ml-4">
                            <p class="font-semibold text-gray-900 text-sm">Rp {{ number_format($item->unit_price * $item->quantity, 0, ',', '.') }}</p>
                            <p class="text-gray-600 text-xs">Qty: {{ $item->quantity }}</p>
                            <p class="text-gray-500 text-xs">@ Rp {{ number_format($item->unit_price, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Right Column - Customer & Actions -->
        <div class="space-y-6">
            <!-- Customer Information - Compact -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class='bx bx-user mr-2'></i>
                    Customer
                </h3>

                <div class="space-y-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                            <i class='bx bx-user text-blue-600'></i>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">{{ $order->user->name }}</p>
                            <p class="text-gray-600 text-sm">{{ $order->user->email }}</p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center">
                            <i class='bx bx-phone text-green-600'></i>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">Phone</p>
                            <p class="text-gray-600 text-sm">{{ $order->user->phone ?? '08123456789' }}</p>
                        </div>
                    </div>

                    @if($order->delivery_address)
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center">
                            <i class='bx bx-map text-purple-600'></i>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">Address</p>
                            <p class="text-gray-600 text-sm">{{ $order->delivery_address }}</p>
                        </div>
                    </div>
                    @endif

                    @if($order->special_instructions)
                    <div class="bg-amber-50 border border-amber-200 rounded-lg p-3">
                        <div class="flex items-start space-x-2">
                            <i class='bx bx-message-rounded text-amber-600 mt-0.5'></i>
                            <div>
                                <p class="text-sm font-medium text-amber-900">Special Instructions</p>
                                <p class="text-amber-800 text-sm mt-1">{{ $order->special_instructions }}</p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Order Summary - Compact -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Order Summary</h3>

                <div class="space-y-3">
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-600">Subtotal</span>
                        <span class="font-semibold">Rp {{ number_format($order->total_amount - $order->tax_amount - $order->delivery_fee, 0, ',', '.') }}</span>
                    </div>

                    @if($order->tax_amount > 0)
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-600">Tax ({{ $order->tax_rate ?? 10 }}%)</span>
                        <span class="font-semibold">Rp {{ number_format($order->tax_amount, 0, ',', '.') }}</span>
                    </div>
                    @endif

                    @if($order->delivery_fee > 0)
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-600">Delivery Fee</span>
                        <span class="font-semibold">Rp {{ number_format($order->delivery_fee, 0, ',', '.') }}</span>
                    </div>
                    @endif

                    <div class="border-t border-gray-200 pt-3">
                        <div class="flex justify-between items-center">
                            <span class="font-semibold text-gray-900">Total</span>
                            <span class="text-lg font-bold text-green-600">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="flex justify-between items-center text-xs text-gray-500 pt-2">
                        <span>Payment:</span>
                        <span class="capitalize font-medium">{{ $order->payment_method ?? 'card' }}</span>
                    </div>

                    <div class="flex justify-between items-center text-xs text-gray-500">
                        <span>Type:</span>
                        <span class="capitalize font-medium">{{ $order->order_type === 'delivery' ? 'Delivery' : 'Pickup' }}</span>
                    </div>
                </div>
            </div>

            <!-- Quick Actions - Compact -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>

                <div class="space-y-3">
                    <!-- Status Update Buttons -->
                    @if($order->status == 'pending')
                    <form action="{{ route('owner.orders.status', $order) }}" method="POST" class="w-full">
                        @csrf @method('PUT')
                        <input type="hidden" name="status" value="confirmed">
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 px-4 rounded-xl font-medium transition flex items-center justify-center space-x-2">
                            <i class='bx bx-check'></i>
                            <span>Confirm Order</span>
                        </button>
                    </form>
                    @endif

                    @if($order->status == 'confirmed')
                    <form action="{{ route('owner.orders.status', $order) }}" method="POST" class="w-full">
                        @csrf @method('PUT')
                        <input type="hidden" name="status" value="preparing">
                        <button type="submit" class="w-full bg-orange-600 hover:bg-orange-700 text-white py-3 px-4 rounded-xl font-medium transition flex items-center justify-center space-x-2">
                            <i class='bx bx-bowl-hot'></i>
                            <span>Start Preparing</span>
                        </button>
                    </form>
                    @endif

                    @if($order->status == 'preparing')
                    <form action="{{ route('owner.orders.status', $order) }}" method="POST" class="w-full">
                        @csrf @method('PUT')
                        <input type="hidden" name="status" value="ready">
                        <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-3 px-4 rounded-xl font-medium transition flex items-center justify-center space-x-2">
                            <i class='bx bx-check-double'></i>
                            <span>Mark as Ready</span>
                        </button>
                    </form>
                    @endif

                    @if($order->status == 'ready')
                    <form action="{{ route('owner.orders.status', $order) }}" method="POST" class="w-full">
                        @csrf @method('PUT')
                        <input type="hidden" name="status" value="completed">
                        <button type="submit" class="w-full bg-gray-800 hover:bg-gray-900 text-white py-3 px-4 rounded-xl font-medium transition flex items-center justify-center space-x-2">
                            <i class='bx bx-check-circle'></i>
                            <span>Complete Order</span>
                        </button>
                    </form>
                    @endif

                    <!-- Cancel Button -->
                    @if(!in_array($order->status, ['completed', 'cancelled']))
                    <form action="{{ route('owner.orders.status', $order) }}" method="POST" class="w-full"
                          onsubmit="return confirm('Are you sure you want to cancel this order?')">
                        @csrf @method('PUT')
                        <input type="hidden" name="status" value="cancelled">
                        <button type="submit" class="w-full border border-red-600 text-red-600 hover:bg-red-50 py-3 px-4 rounded-xl font-medium transition flex items-center justify-center space-x-2">
                            <i class='bx bx-x'></i>
                            <span>Cancel Order</span>
                        </button>
                    </form>
                    @endif

                    <!-- Additional Actions -->
                    <div class="grid grid-cols-2 gap-3 pt-3 border-t border-gray-200">
                        <a href="{{ route('owner.orders.receipt', $order) }}" target="_blank"
                           class="p-3 border border-gray-300 rounded-xl hover:bg-gray-50 transition flex items-center justify-center space-x-2 text-sm">
                            <i class='bx bx-printer'></i>
                            <span>Print Receipt</span>
                        </a>
                        <button class="p-3 border border-gray-300 rounded-xl hover:bg-gray-50 transition flex items-center justify-center space-x-2 text-sm">
                            <i class='bx bx-message'></i>
                            <span>Message</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .compact-timeline {
        @apply relative;
    }

    .compact-timeline-step {
        @apply flex flex-col items-center relative;
    }

    .compact-timeline-dot {
        @apply w-6 h-6 rounded-full flex items-center justify-center text-xs font-medium relative z-10;
    }

    .compact-timeline-label {
        @apply text-xs font-medium mt-1;
    }

    .status-badge.pending { @apply bg-yellow-100 text-yellow-800 border border-yellow-200; }
    .status-badge.confirmed { @apply bg-blue-100 text-blue-800 border border-blue-200; }
    .status-badge.preparing { @apply bg-orange-100 text-orange-800 border border-orange-200; }
    .status-badge.ready { @apply bg-green-100 text-green-800 border border-green-200; }
    .status-badge.completed { @apply bg-gray-100 text-gray-800 border border-gray-200; }
    .status-badge.cancelled { @apply bg-red-100 text-red-800 border border-red-200; }
</style>
@endsection
