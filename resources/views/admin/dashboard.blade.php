@extends('layouts.admin')

@section('title', 'Dashboard Overview')

@section('content')
<div class="space-y-6">
    <!-- Welcome Card -->
    <div class="bg-gradient-to-r from-primary-500 to-primary-600 rounded-2xl p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold">Hello, {{ auth()->user()->name }}! 👋</h1>
                <p class="text-primary-100 mt-1">Here's what's happening with your platform today</p>
            </div>
            <div class="flex items-center space-x-4 text-primary-100">
                <div class="text-center">
                    <p class="text-sm">Today's Date</p>
                    <p class="font-semibold">{{ now()->format('F j, Y') }}</p>
                </div>
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                    <i class='bx bx-calendar text-xl'></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Restaurants -->
        <div class="stat-card bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Total Restaurants</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">24</p>
                    <div class="flex items-center mt-2">
                        <i class='bx bx-up-arrow-alt text-green-500 text-sm'></i>
                        <span class="text-green-600 text-sm font-medium ml-1">+3 this week</span>
                    </div>
                </div>
                <div class="w-14 h-14 bg-green-100 rounded-2xl flex items-center justify-center">
                    <i class='bx bx-store-alt text-2xl text-green-600'></i>
                </div>
            </div>
        </div>

        <!-- Active Users -->
        <div class="stat-card bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Active Users</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">1,847</p>
                    <div class="flex items-center mt-2">
                        <i class='bx bx-up-arrow-alt text-green-500 text-sm'></i>
                        <span class="text-green-600 text-sm font-medium ml-1">+5.2% growth</span>
                    </div>
                </div>
                <div class="w-14 h-14 bg-blue-100 rounded-2xl flex items-center justify-center">
                    <i class='bx bx-user-circle text-2xl text-blue-600'></i>
                </div>
            </div>
        </div>

        <!-- Today's Orders -->
        <div class="stat-card bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Today's Orders</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">156</p>
                    <div class="flex items-center mt-2">
                        <i class='bx bx-time text-orange-500 text-sm'></i>
                        <span class="text-orange-600 text-sm font-medium ml-1">28 pending</span>
                    </div>
                </div>
                <div class="w-14 h-14 bg-orange-100 rounded-2xl flex items-center justify-center">
                    <i class='bx bx-receipt text-2xl text-orange-600'></i>
                </div>
            </div>
        </div>

        <!-- Revenue -->
        <div class="stat-card bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Revenue</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">Rp 12.8M</p>
                    <div class="flex items-center mt-2">
                        <i class='bx bx-up-arrow-alt text-green-500 text-sm'></i>
                        <span class="text-green-600 text-sm font-medium ml-1">+18.3% growth</span>
                    </div>
                </div>
                <div class="w-14 h-14 bg-purple-100 rounded-2xl flex items-center justify-center">
                    <i class='bx bx-credit-card text-2xl text-purple-600'></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Two Column Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Activity -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-semibold text-gray-900">Recent Activity</h2>
                <button class="text-primary-600 hover:text-primary-700 text-sm font-medium">View All</button>
            </div>

            <div class="space-y-4">
                @foreach([1,2,3,4] as $activity)
                <div class="flex items-center space-x-4 p-3 rounded-xl hover:bg-gray-50 transition">
                    <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class='bx bx-check text-green-600'></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-gray-900 font-medium">New order completed</p>
                        <p class="text-gray-500 text-sm">Order #ORD{{ 1200 + $activity }} • Just now</p>
                    </div>
                    <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">Completed</span>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <h2 class="text-lg font-semibold text-gray-900 mb-6">Quick Actions</h2>

            <div class="grid grid-cols-2 gap-4">
                <button class="p-4 rounded-xl border-2 border-dashed border-gray-200 hover:border-primary-300 hover:bg-primary-50 transition text-center group">
                    <i class='bx bx-plus-circle text-2xl text-gray-400 group-hover:text-primary-500 mb-2 block'></i>
                    <span class="text-sm font-medium text-gray-600 group-hover:text-primary-700">Add Restaurant</span>
                </button>

                <button class="p-4 rounded-xl border-2 border-dashed border-gray-200 hover:border-blue-300 hover:bg-blue-50 transition text-center group">
                    <i class='bx bx-user-plus text-2xl text-gray-400 group-hover:text-blue-500 mb-2 block'></i>
                    <span class="text-sm font-medium text-gray-600 group-hover:text-blue-700">Manage Users</span>
                </button>

                <button class="p-4 rounded-xl border-2 border-dashed border-gray-200 hover:border-orange-300 hover:bg-orange-50 transition text-center group">
                    <i class='bx bx-cog text-2xl text-gray-400 group-hover:text-orange-500 mb-2 block'></i>
                    <span class="text-sm font-medium text-gray-600 group-hover:text-orange-700">Settings</span>
                </button>

                <button class="p-4 rounded-xl border-2 border-dashed border-gray-200 hover:border-purple-300 hover:bg-purple-50 transition text-center group">
                    <i class='bx bx-bar-chart-alt text-2xl text-gray-400 group-hover:text-purple-500 mb-2 block'></i>
                    <span class="text-sm font-medium text-gray-600 group-hover:text-purple-700">Analytics</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Platform Performance -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
        <h2 class="text-lg font-semibold text-gray-900 mb-6">Platform Performance</h2>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <div class="text-center p-4 rounded-xl bg-green-50 border border-green-100">
                <div class="w-12 h-12 bg-green-500 rounded-2xl flex items-center justify-center mx-auto mb-3">
                    <i class='bx bx-check-shield text-2xl text-white'></i>
                </div>
                <p class="text-2xl font-bold text-gray-900">98.7%</p>
                <p class="text-gray-600 text-sm mt-1">Uptime</p>
            </div>

            <div class="text-center p-4 rounded-xl bg-blue-50 border border-blue-100">
                <div class="w-12 h-12 bg-blue-500 rounded-2xl flex items-center justify-center mx-auto mb-3">
                    <i class='bx bx-trending-up text-2xl text-white'></i>
                </div>
                <p class="text-2xl font-bold text-gray-900">4.8/5</p>
                <p class="text-gray-600 text-sm mt-1">Avg Rating</p>
            </div>

            <div class="text-center p-4 rounded-xl bg-orange-50 border border-orange-100">
                <div class="w-12 h-12 bg-orange-500 rounded-2xl flex items-center justify-center mx-auto mb-3">
                    <i class='bx bx-time text-2xl text-white'></i>
                </div>
                <p class="text-2xl font-bold text-gray-900">22min</p>
                <p class="text-gray-600 text-sm mt-1">Avg Delivery</p>
            </div>

            <div class="text-center p-4 rounded-xl bg-purple-50 border border-purple-100">
                <div class="w-12 h-12 bg-purple-500 rounded-2xl flex items-center justify-center mx-auto mb-3">
                    <i class='bx bx-happy text-2xl text-white'></i>
                </div>
                <p class="text-2xl font-bold text-gray-900">96%</p>
                <p class="text-gray-600 text-sm mt-1">Satisfaction</p>
            </div>
        </div>
    </div>
</div>
@endsection
