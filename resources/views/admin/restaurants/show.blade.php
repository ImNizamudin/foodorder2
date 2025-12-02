@extends('layouts.admin')

@section('title', $title)

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.restaurants') }}" class="text-gray-400 hover:text-gray-600 transition">
                    <i class='bx bx-arrow-back text-2xl'></i>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Restaurant Details</h1>
                    <p class="text-gray-600">Complete information about {{ $restaurant->name }}</p>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <!-- Status Toggle -->
                <form action="{{ route('admin.restaurants.status', $restaurant) }}" method="POST" class="inline">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" value="{{ $restaurant->status === 'active' ? 'inactive' : 'active' }}">
                    <button type="submit"
                            class="px-4 py-2 rounded-xl font-medium transition flex items-center space-x-2
                                   {{ $restaurant->status === 'active'
                                       ? 'bg-orange-100 text-orange-700 hover:bg-orange-200'
                                       : 'bg-green-100 text-green-700 hover:bg-green-200' }}">
                        <i class='bx bx-{{ $restaurant->status === 'active' ? 'pause' : 'play' }}'></i>
                        <span>{{ $restaurant->status === 'active' ? 'Deactivate' : 'Activate' }}</span>
                    </button>
                </form>

                <!-- Delete -->
                <form action="{{ route('admin.restaurants.destroy', $restaurant) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-xl font-medium transition flex items-center space-x-2"
                            onclick="return confirm('Are you sure you want to delete this restaurant?')">
                        <i class='bx bx-trash'></i>
                        <span>Delete</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column - Restaurant Info -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Restaurant Profile Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
                    <div class="p-6 border-b border-gray-100">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="w-16 h-16 bg-gradient-to-r from-primary-500 to-primary-600 rounded-2xl flex items-center justify-center">
                                    <i class='bx bx-restaurant text-2xl text-white'></i>
                                </div>
                                <div>
                                    <h2 class="text-xl font-bold text-gray-900">{{ $restaurant->name }}</h2>
                                    <p class="text-gray-600">{{ $restaurant->description }}</p>
                                    <div class="flex items-center space-x-2 mt-2">
                                        @if($restaurant->status === 'active')
                                            <span class="px-3 py-1 bg-green-100 text-green-800 text-sm rounded-full font-medium">Active</span>
                                        @else
                                            <span class="px-3 py-1 bg-gray-100 text-gray-800 text-sm rounded-full font-medium">Inactive</span>
                                        @endif
                                        <span class="px-3 py-1 bg-blue-100 text-blue-800 text-sm rounded-full font-medium">Restaurant</span>
                                    </div>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm text-gray-600">Restaurant ID</p>
                                <p class="font-mono text-sm text-gray-900">#{{ $restaurant->id }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="p-6 border-b border-gray-100">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Contact Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-3">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                                        <i class='bx bx-phone text-blue-600'></i>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Phone</p>
                                        <p class="font-medium text-gray-900">{{ $restaurant->phone }}</p>
                                    </div>
                                </div>

                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center">
                                        <i class='bx bx-envelope text-green-600'></i>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Email</p>
                                        <p class="font-medium text-gray-900">{{ $restaurant->email ?? 'Not provided' }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-3">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center">
                                        <i class='bx bx-map text-purple-600'></i>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Address</p>
                                        <p class="font-medium text-gray-900">{{ $restaurant->address }}</p>
                                    </div>
                                </div>

                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-orange-100 rounded-xl flex items-center justify-center">
                                        <i class='bx bx-calendar text-orange-600'></i>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Registered</p>
                                        <p class="font-medium text-gray-900">{{ $restaurant->created_at->format('M j, Y') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Owner Information -->
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Owner Information</h3>
                        <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-xl">
                            <div class="w-12 h-12 bg-gradient-to-r from-primary-500 to-primary-600 rounded-full flex items-center justify-center">
                                <span class="text-white font-semibold text-sm">
                                    {{ strtoupper(substr($restaurant->user->name, 0, 1)) }}
                                </span>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-semibold text-gray-900">{{ $restaurant->user->name }}</h4>
                                <p class="text-gray-600 text-sm">{{ $restaurant->user->email }}</p>
                                <p class="text-gray-500 text-xs">Phone: {{ $restaurant->user->phone }}</p>
                            </div>
                            <div class="text-right">
                                <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full font-medium">Owner</span>
                                <p class="text-xs text-gray-500 mt-1">User #{{ $restaurant->user->id }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Menu Items Section -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
                    <div class="p-6 border-b border-gray-100">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-900">Menu Items</h3>
                            <span class="bg-primary-100 text-primary-800 px-3 py-1 rounded-full text-sm font-medium">
                                {{ $restaurant->menuItems->count() }} items
                            </span>
                        </div>
                    </div>

                    <div class="p-6">
                        @if($restaurant->menuItems->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($restaurant->menuItems->take(4) as $item)
                            <div class="flex items-center space-x-3 p-3 border border-gray-200 rounded-xl hover:bg-gray-50 transition">
                                <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center">
                                    <i class='bx bx-food-menu text-primary-600'></i>
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-medium text-gray-900">{{ $item->name }}</h4>
                                    <p class="text-sm text-gray-600">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                </div>
                                <div>
                                    @if($item->is_available)
                                        <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Available</span>
                                    @else
                                        <span class="px-2 py-1 bg-gray-100 text-gray-800 text-xs rounded-full">Unavailable</span>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>

                        @if($restaurant->menuItems->count() > 4)
                        <div class="text-center mt-4 pt-4 border-t border-gray-100">
                            <button class="text-primary-600 hover:text-primary-700 font-medium">
                                View All {{ $restaurant->menuItems->count() }} Menu Items
                            </button>
                        </div>
                        @endif

                        @else
                        <div class="text-center py-8">
                            <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                <i class='bx bx-food-menu text-2xl text-gray-400'></i>
                            </div>
                            <h4 class="text-lg font-medium text-gray-900 mb-2">No Menu Items</h4>
                            <p class="text-gray-600 mb-4">This restaurant hasn't added any menu items yet.</p>
                            <button class="bg-primary-500 hover:bg-primary-600 text-white px-4 py-2 rounded-xl font-medium transition">
                                Add Menu Items
                            </button>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right Column - Stats & Actions -->
            <div class="space-y-6">
                <!-- Restaurant Stats -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Restaurant Stats</h3>

                    <div class="space-y-4">
                        <div class="flex justify-between items-center pb-3 border-b border-gray-100">
                            <div class="flex items-center space-x-2">
                                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <i class='bx bx-receipt text-blue-600 text-sm'></i>
                                </div>
                                <span class="text-gray-700">Total Orders</span>
                            </div>
                            <span class="font-semibold text-gray-900">156</span>
                        </div>

                        <div class="flex justify-between items-center pb-3 border-b border-gray-100">
                            <div class="flex items-center space-x-2">
                                <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                                    <i class='bx bx-credit-card text-green-600 text-sm'></i>
                                </div>
                                <span class="text-gray-700">Revenue</span>
                            </div>
                            <span class="font-semibold text-gray-900">Rp 12.8M</span>
                        </div>

                        <div class="flex justify-between items-center pb-3 border-b border-gray-100">
                            <div class="flex items-center space-x-2">
                                <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center">
                                    <i class='bx bx-star text-orange-600 text-sm'></i>
                                </div>
                                <span class="text-gray-700">Rating</span>
                            </div>
                            <span class="font-semibold text-gray-900">4.7/5</span>
                        </div>

                        <div class="flex justify-between items-center">
                            <div class="flex items-center space-x-2">
                                <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                                    <i class='bx bx-user text-purple-600 text-sm'></i>
                                </div>
                                <span class="text-gray-700">Active Customers</span>
                            </div>
                            <span class="font-semibold text-gray-900">89</span>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>

                    <div class="space-y-3">
                        <button class="w-full bg-primary-50 hover:bg-primary-100 text-primary-700 py-3 px-4 rounded-xl transition font-medium flex items-center justify-center space-x-2">
                            <i class='bx bx-edit'></i>
                            <span>Edit Restaurant</span>
                        </button>

                        <button class="w-full bg-blue-50 hover:bg-blue-100 text-blue-700 py-3 px-4 rounded-xl transition font-medium flex items-center justify-center space-x-2">
                            <i class='bx bx-food-menu'></i>
                            <span>Manage Menu</span>
                        </button>

                        <button class="w-full bg-green-50 hover:bg-green-100 text-green-700 py-3 px-4 rounded-xl transition font-medium flex items-center justify-center space-x-2">
                            <i class='bx bx-bar-chart-alt'></i>
                            <span>View Analytics</span>
                        </button>

                        <button class="w-full bg-orange-50 hover:bg-orange-100 text-orange-700 py-3 px-4 rounded-xl transition font-medium flex items-center justify-center space-x-2">
                            <i class='bx bx-envelope'></i>
                            <span>Contact Owner</span>
                        </button>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Activity</h3>

                    <div class="space-y-3">
                        <div class="flex items-center space-x-3 p-2">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                <i class='bx bx-check text-green-600 text-sm'></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-gray-900">New order completed</p>
                                <p class="text-xs text-gray-500">2 hours ago</p>
                            </div>
                        </div>

                        <div class="flex items-center space-x-3 p-2">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                <i class='bx bx-edit text-blue-600 text-sm'></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-gray-900">Menu updated</p>
                                <p class="text-xs text-gray-500">5 hours ago</p>
                            </div>
                        </div>

                        <div class="flex items-center space-x-3 p-2">
                            <div class="w-8 h-8 bg-orange-100 rounded-full flex items-center justify-center">
                                <i class='bx bx-star text-orange-600 text-sm'></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-gray-900">New 5-star review</p>
                                <p class="text-xs text-gray-500">1 day ago</p>
                            </div>
                        </div>
                    </div>

                    <button class="w-full mt-4 text-primary-600 hover:text-primary-700 font-medium text-sm">
                        View All Activity
                    </button>
                </div>
            </div>
        </div>

        <!-- Performance Metrics -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
            <div class="p-6 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900">Performance Metrics</h3>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    <div class="text-center p-4 rounded-xl bg-blue-50 border border-blue-100">
                        <div class="w-12 h-12 bg-blue-500 rounded-2xl flex items-center justify-center mx-auto mb-3">
                            <i class='bx bx-timer text-2xl text-white'></i>
                        </div>
                        <p class="text-2xl font-bold text-gray-900">18min</p>
                        <p class="text-gray-600 text-sm mt-1">Avg Prep Time</p>
                    </div>

                    <div class="text-center p-4 rounded-xl bg-green-50 border border-green-100">
                        <div class="w-12 h-12 bg-green-500 rounded-2xl flex items-center justify-center mx-auto mb-3">
                            <i class='bx bx-check-circle text-2xl text-white'></i>
                        </div>
                        <p class="text-2xl font-bold text-gray-900">98%</p>
                        <p class="text-gray-600 text-sm mt-1">Success Rate</p>
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
                        <p class="text-2xl font-bold text-gray-900">+24%</p>
                        <p class="text-gray-600 text-sm mt-1">Growth</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
