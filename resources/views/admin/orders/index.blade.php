@extends('layouts.admin')

@section('title', 'Order Management')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Order Management</h1>
            <p class="text-gray-600">Manage and track all orders on the platform</p>
        </div>
        <div class="flex items-center space-x-4">
            <div class="bg-white px-4 py-2 rounded-xl border border-gray-200">
                <p class="text-sm text-gray-600">Total Orders</p>
                <p class="text-lg font-semibold text-center text-gray-900">{{ $stats['total'] }}</p>
            </div>
        </div>
    </div>

    <!-- Order Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Total Orders</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $stats['total'] }}</p>
                    <div class="flex items-center mt-2">
                        <i class='bx bx-up-arrow-alt text-green-500 text-sm'></i>
                        <span class="text-green-600 text-sm font-medium ml-1">+12% growth</span>
                    </div>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-2xl flex items-center justify-center">
                    <i class='bx bx-receipt text-2xl text-blue-600'></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Pending Orders</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $stats['pending'] }}</p>
                    <div class="flex items-center mt-2">
                        <i class='bx bx-time text-orange-500 text-sm'></i>
                        <span class="text-orange-600 text-sm font-medium ml-1">Need attention</span>
                    </div>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-2xl flex items-center justify-center">
                    <i class='bx bx-time-five text-2xl text-orange-600'></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Completed</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $stats['completed'] }}</p>
                    <div class="flex items-center mt-2">
                        <i class='bx bx-check text-green-500 text-sm'></i>
                        <span class="text-green-600 text-sm font-medium ml-1">{{ number_format($stats['completed'] / max($stats['total'], 1) * 100, 1) }}% rate</span>
                    </div>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-2xl flex items-center justify-center">
                    <i class='bx bx-check-circle text-2xl text-green-600'></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Total Revenue</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">Rp {{ number_format($stats['revenue'], 0, ',', '.') }}</p>
                    <div class="flex items-center mt-2">
                        <i class='bx bx-up-arrow-alt text-green-500 text-sm'></i>
                        <span class="text-green-600 text-sm font-medium ml-1">+18% growth</span>
                    </div>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-2xl flex items-center justify-center">
                    <i class='bx bx-credit-card text-2xl text-purple-600'></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
        <div class="p-6 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-900">Recent Orders</h2>
                <div class="flex items-center space-x-3">
                    <input type="text" placeholder="Search orders..."
                           class="px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-primary-300">
                    <select class="px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-primary-300">
                        <option value="">All Status</option>
                        <option value="pending">Pending</option>
                        <option value="confirmed">Confirmed</option>
                        <option value="preparing">Preparing</option>
                        <option value="ready">Ready</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order Info</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Restaurant</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @foreach($orders as $order)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div>
                                <div class="text-sm font-medium text-gray-900">{{ $order->order_number }}</div>
                                <div class="text-sm text-gray-500">{{ $order->created_at->format('M j, Y H:i') }}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $order->customer_name }}</div>
                            <div class="text-sm text-gray-500">{{ $order->customer_phone }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $order->restaurant->name }}</div>
                            <div class="text-sm text-gray-500">{{ $order->restaurant->phone }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-semibold text-gray-900">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @switch($order->status)
                                @case('pending')
                                    <span class="px-3 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full font-medium">Pending</span>
                                    @break
                                @case('confirmed')
                                    <span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs rounded-full font-medium">Confirmed</span>
                                    @break
                                @case('preparing')
                                    <span class="px-3 py-1 bg-orange-100 text-orange-800 text-xs rounded-full font-medium">Preparing</span>
                                    @break
                                @case('ready')
                                    <span class="px-3 py-1 bg-green-100 text-green-800 text-xs rounded-full font-medium">Ready</span>
                                    @break
                                @case('completed')
                                    <span class="px-3 py-1 bg-gray-100 text-gray-800 text-xs rounded-full font-medium">Completed</span>
                                    @break
                                @case('cancelled')
                                    <span class="px-3 py-1 bg-red-100 text-red-800 text-xs rounded-full font-medium">Cancelled</span>
                                    @break
                            @endswitch
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('admin.orders.show', $order) }}"
                                   class="text-primary-600 hover:text-primary-900 transition" title="View Details">
                                    <i class='bx bx-show text-lg'></i>
                                </a>

                                <!-- Status Update Dropdown -->
                                <div class="relative" x-data="{ open: false }">
                                    <button @click="open = !open" class="text-gray-600 hover:text-gray-900 transition" title="Update Status">
                                        <i class='bx bx-cog text-lg'></i>
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
                                            class="text-red-600 hover:text-red-900 transition"
                                            title="Delete Order"
                                            onclick="return confirm('Are you sure you want to delete this order?')">
                                        <i class='bx bx-trash text-lg'></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $orders->links() }}
        </div>
    </div>
</div>
@endsection
