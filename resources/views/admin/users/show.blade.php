@extends('layouts.admin')

@section('title', $title)

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
        <!-- Header -->
        <div class="p-6 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('admin.users') }}" class="text-gray-400 hover:text-gray-600 transition">
                        <i class='bx bx-arrow-back text-xl'></i>
                    </a>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">User Details</h1>
                        <p class="text-gray-600">View and manage user information</p>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    @if($user->id !== auth()->id())
                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-xl font-medium transition flex items-center space-x-2"
                                onclick="return confirm('Are you sure you want to delete this user?')">
                            <i class='bx bx-trash'></i>
                            <span>Delete User</span>
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>

        <!-- User Info -->
        <div class="p-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Basic Info -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Profile Card -->
                    <div class="bg-gray-50 rounded-xl p-6">
                        <div class="flex items-center space-x-4">
                            <div class="w-20 h-20 bg-gradient-to-r from-primary-500 to-primary-600 rounded-2xl flex items-center justify-center">
                                <span class="text-white font-bold text-2xl">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </span>
                            </div>
                            <div>
                                <h2 class="text-xl font-bold text-gray-900">{{ $user->name }}</h2>
                                <p class="text-gray-600">{{ $user->email }}</p>
                                <div class="flex items-center space-x-2 mt-2">
                                    @if($user->role === 'admin')
                                        <span class="px-3 py-1 bg-purple-100 text-purple-800 text-sm rounded-full font-medium">Admin</span>
                                    @elseif($user->role === 'owner')
                                        <span class="px-3 py-1 bg-green-100 text-green-800 text-sm rounded-full font-medium">Restaurant Owner</span>
                                    @else
                                        <span class="px-3 py-1 bg-blue-100 text-blue-800 text-sm rounded-full font-medium">Customer</span>
                                    @endif
                                    <span class="px-3 py-1 bg-green-100 text-green-800 text-sm rounded-full font-medium">Active</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Details Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-white border border-gray-200 rounded-xl p-4">
                            <p class="text-sm text-gray-600 mb-1">Phone Number</p>
                            <p class="font-medium text-gray-900">{{ $user->phone ?? 'Not provided' }}</p>
                        </div>

                        <div class="bg-white border border-gray-200 rounded-xl p-4">
                            <p class="text-sm text-gray-600 mb-1">Member Since</p>
                            <p class="font-medium text-gray-900">{{ $user->created_at->format('F j, Y') }}</p>
                        </div>

                        <div class="bg-white border border-gray-200 rounded-xl p-4">
                            <p class="text-sm text-gray-600 mb-1">Last Updated</p>
                            <p class="font-medium text-gray-900">{{ $user->updated_at->format('F j, Y') }}</p>
                        </div>

                        <div class="bg-white border border-gray-200 rounded-xl p-4">
                            <p class="text-sm text-gray-600 mb-1">Email Verified</p>
                            <p class="font-medium text-gray-900">
                                @if($user->email_verified_at)
                                    <span class="text-green-600">Verified</span>
                                @else
                                    <span class="text-orange-600">Not Verified</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="space-y-6">
                    <div class="bg-primary-50 border border-primary-200 rounded-xl p-6">
                        <h3 class="font-semibold text-gray-900 mb-4">Account Summary</h3>

                        <div class="space-y-4">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Status</span>
                                <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs font-medium">Active</span>
                            </div>

                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Role</span>
                                <span class="font-medium text-gray-900 capitalize">{{ $user->role }}</span>
                            </div>

                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">User ID</span>
                                <span class="font-medium text-gray-900">#{{ $user->id }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="bg-white border border-gray-200 rounded-xl p-6">
                        <h3 class="font-semibold text-gray-900 mb-4">Quick Actions</h3>
                        <div class="space-y-3">
                            <button class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 py-2 px-4 rounded-lg transition text-sm font-medium">
                                Send Email
                            </button>
                            <button class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 py-2 px-4 rounded-lg transition text-sm font-medium">
                                Reset Password
                            </button>
                            @if($user->role === 'owner')
                            <button class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 py-2 px-4 rounded-lg transition text-sm font-medium">
                                View Restaurants
                            </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
