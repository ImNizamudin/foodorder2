@extends('layouts.admin')

@section('title', $title)

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.orders') }}" class="text-gray-400 hover:text-gray-600 transition">
                    <i class='bx bx-arrow-back text-2xl'></i>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Order Details</h1>
                    <p class="text-gray-600">Complete information about order {{ $order->order_number }}</p>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <!-- Status Update -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open"
                            class="px-4 py-2 rounded-xl font-medium transition flex items-center space-x-2
                                   @switch($order->status)
                                       @case('pending') bg-yellow-100 text-yellow-700 hover:bg-yellow-200 @break
                                       @case('confirmed') bg-blue-100 text-blue-700 hover:bg-blue-200 @break
                                       @case('preparing') bg-orange-100 text-orange-700 hover:bg-orange-200 @break
                                       @case('ready') bg-green-100 text-green-700 hover:bg-green-200 @break
                                       @case('completed') bg-gray-100 text-gray-700 hover:bg-gray-200 @break
                                       @case('cancelled') bg-red-100 text-red-700 hover:bg-red-200 @break
                                   @endswitch">
                        <i class='bx bx-cog'></i>
                        <span>Update Status</span>
                    </button>

                    <div x-show="open" @click.away="open = false"
                         class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 py-1 z-50">
                        @foreach(['pending', 'confirmed', 'preparing', 'ready', 'completed', 'cancelled'] as $status)
                            @if($status !== $order->status)
                            <form action="{{ route('admin.orders.status', $order) }}" method="POST" class="block">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="{{ $status }}">
                                <button type="submit"
                                        class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition capitalize">
                                    Mark as {{ $status }}
                                </button>
                            </form>
                            @endif
                        @endforeach
                    </div>
                </div>

                <!-- Delete -->
                <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-xl font-medium transition flex items-center space-x-2"
                            onclick="return confirm('Are you sure you want to delete this order?')">
                        <i class='bx bx-trash'></i>
                        <span>Delete</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column - Order Details -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Order Summary Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
                    <div class="p-6 border-b border-gray-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="text-xl font-bold text-gray-900">Order Summary</h2>
                                <p class="text-gray-600">{{ $order->order_number }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm text-gray-600">Order Date</p>
                                <p class="font-medium text-gray-900">{{ $order->created_at->format('M j, Y H:i') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Order Status Timeline -->
                    <div class="p-6 border-b border-gray-100">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Order Status</h3>
                        <div class="flex items-center justify-between">
                            @php
                                $statuses = [
                                    'pending' => ['icon' => 'bx-time', 'color' => 'yellow', 'label' => 'Pending'],
                                    'confirmed' => ['icon' => 'bx-check', 'color' => 'blue', 'label' => 'Confirmed'],
                                    'preparing' => ['icon' => 'bx-bowl-hot', 'color' => 'orange', 'label' => 'Preparing'],
                                    'ready' => ['icon' => 'bx-check-circle', 'color' => 'green', 'label' => 'Ready'],
                                    'completed' => ['icon' => 'bx-party', 'color' => 'gray', 'label' => 'Completed']
                                ];
                                $currentIndex = array_search($order->status, array_keys($statuses));
                            @endphp

                            @foreach($statuses as $statusKey => $statusInfo)
                                @php
                                    $isCompleted = $currentIndex >= array_search($statusKey, array_keys($statuses));
                                    $isCurrent = $order->status === $statusKey;
                                @endphp
                                <div class="flex flex-col items-center space-y-2">
                                    <div class="w-10 h-10 rounded-full flex items-center justify-center
                                        @if($isCompleted) bg-{{ $statusInfo['color'] }}-500 text-white
                                        @else bg-gray-200 text-gray-400 @endif">
                                        <i class='bx {{ $statusInfo['icon'] }}'></i>
                                    </div>
                                    <span class="text-xs font-medium @if($isCompleted) text-{{ $statusInfo['color'] }}-600 @else text-gray-400 @endif">
                                        {{ $statusInfo['label'] }}
                                    </span>
                                </div>
                                @if(!$loop->last)
                                <div class="flex-1 h-1 @if($isCompleted) bg-{{ $statusInfo['color'] }}-500 @else bg-gray-200 @endif"></div>
                                @endif
                            @endforeach
                        </div>
                    </div>

                    <!-- Order Items -->
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Order Items</h3>
                        <div class="space-y-4">
                            @foreach($order->orderItems as $item)
                            <div class="flex items-center justify-between p-4 border border-gray-200 rounded-xl">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center">
                                        <i class='bx bx-food-menu text-primary-600'></i>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-gray-900">{{ $item->menuItem->name }}</h4>
                                        <p class="text-sm text-gray-600">Rp {{ number_format($item->unit_price, 0, ',', '.') }} × {{ $item->quantity }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="font-semibold text-gray-900">Rp {{ number_format($item->total_price, 0, ',', '.') }}</p>
                                </div>
                            </div>
                            @endforeach

                            <!-- Order Total -->
                            <div class="flex justify-between items-center pt-4 border-t border-gray-200">
                                <span class="text-lg font-semibold text-gray-900">Total Amount</span>
                                <span class="text-xl font-bold text-gray-900">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Customer Information -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
                    <div class="p-6 border-b border-gray-100">
                        <h3 class="text-lg font-semibold text-gray-900">Customer Information</h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-3">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                                        <i class='bx bx-user text-blue-600'></i>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Customer Name</p>
                                        <p class="font-medium text-gray-900">{{ $order->customer_name }}</p>
                                    </div>
                                </div>

                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center">
                                        <i class='bx bx-phone text-green-600'></i>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Phone Number</p>
                                        <p class="font-medium text-gray-900">{{ $order->customer_phone }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-3">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center">
                                        <i class='bx bx-map text-purple-600'></i>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Delivery Address</p>
                                        <p class="font-medium text-gray-900">{{ $order->customer_address }}</p>
                                    </div>
                                </div>

                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-orange-100 rounded-xl flex items-center justify-center">
                                        <i class='bx bx-user-circle text-orange-600'></i>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Platform User</p>
                                        <p class="font-medium text-gray-900">{{ $order->user->name }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Restaurant & Actions -->
            <div class="space-y-6">
                <!-- Restaurant Information -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Restaurant Information</h3>

                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center">
                            <i class='bx bx-restaurant text-primary-600'></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900">{{ $order->restaurant->name }}</h4>
                            <p class="text-sm text-gray-600">{{ $order->restaurant->phone }}</p>
                        </div>
                    </div>

                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Address:</span>
                            <span class="text-gray-900 text-right">{{ Str::limit($order->restaurant->address, 30) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Email:</span>
                            <span class="text-gray-900">{{ $order->restaurant->email ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Status:</span>
                            <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Active</span>
                        </div>
                    </div>

                    <a href="{{ route('admin.restaurants.show', $order->restaurant) }}"
                       class="w-full mt-4 bg-primary-500 hover:bg-primary-600 text-white py-2 px-4 rounded-xl font-medium transition flex items-center justify-center space-x-2">
                        <i class='bx bx-show'></i>
                        <span>View Restaurant</span>
                    </a>
                </div>

                <!-- Order Notes -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Order Notes</h3>

                    @if($order->notes)
                    <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4">
                        <p class="text-sm text-yellow-800">{{ $order->notes }}</p>
                    </div>
                    @else
                    <div class="text-center py-4">
                        <i class='bx bx-note text-3xl text-gray-300 mb-2'></i>
                        <p class="text-gray-500 text-sm">No special instructions</p>
                    </div>
                    @endif
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>

                    <div class="space-y-3">
                        <button class="w-full bg-blue-50 hover:bg-blue-100 text-blue-700 py-3 px-4 rounded-xl transition font-medium flex items-center justify-center space-x-2">
                            <i class='bx bx-printer'></i>
                            <span>Print Receipt</span>
                        </button>

                        <button class="w-full bg-green-50 hover:bg-green-100 text-green-700 py-3 px-4 rounded-xl transition font-medium flex items-center justify-center space-x-2">
                            <i class='bx bx-envelope'></i>
                            <span>Contact Customer</span>
                        </button>

                        <button class="w-full bg-orange-50 hover:bg-orange-100 text-orange-700 py-3 px-4 rounded-xl transition font-medium flex items-center justify-center space-x-2">
                            <i class='bx bx-chat'></i>
                            <span>Contact Restaurant</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
