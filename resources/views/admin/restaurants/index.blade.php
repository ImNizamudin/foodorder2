@extends('layouts.admin')

@section('title', 'Restaurant Management')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Restaurant Management</h1>
            <p class="text-gray-600">Manage all restaurants on the platform</p>
        </div>
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.restaurants.create') }}"
               class="bg-primary-500 hover:bg-primary-600 text-white px-6 py-3 rounded-xl font-medium transition flex items-center space-x-2">
                <i class='bx bx-plus'></i>
                <span>Add Restaurant</span>
            </a>
            <div class="bg-white px-4 py-2 rounded-xl border border-gray-200">
                <p class="text-sm text-gray-600">Total Restaurants</p>
                <p class="text-lg font-semibold text-center text-gray-900">{{ $restaurants->total() }}</p>
            </div>
        </div>
    </div>

    <!-- Restaurant Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Active Restaurants</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">
                        {{ $restaurants->where('status', 'active')->count() }}
                    </p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-2xl flex items-center justify-center">
                    <i class='bx bx-check-circle text-2xl text-green-600'></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Inactive</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">
                        {{ $restaurants->where('status', 'inactive')->count() }}
                    </p>
                </div>
                <div class="w-12 h-12 bg-gray-100 rounded-2xl flex items-center justify-center">
                    <i class='bx bx-pause-circle text-2xl text-gray-600'></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Total Owners</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">
                        {{ $restaurants->pluck('user_id')->unique()->count() }}
                    </p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-2xl flex items-center justify-center">
                    <i class='bx bx-user-check text-2xl text-blue-600'></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Avg Rating</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">4.7/5</p>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-2xl flex items-center justify-center">
                    <i class='bx bx-star text-2xl text-orange-600'></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Restaurants Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
        <div class="p-6 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-900">All Restaurants</h2>
                <div class="flex items-center space-x-3">
                    <input type="text" placeholder="Search restaurants..."
                           class="px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-primary-300">
                    <select class="px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-primary-300">
                        <option value="">All Status</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Restaurant</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Owner</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @foreach($restaurants as $restaurant)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-gradient-to-r from-primary-500 to-primary-600 rounded-2xl flex items-center justify-center">
                                    <i class='bx bx-restaurant text-xl text-white'></i>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $restaurant->name }}</div>
                                    <div class="text-sm text-gray-500">{{ Str::limit($restaurant->description, 50) }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $restaurant->user->name }}</div>
                            <div class="text-sm text-gray-500">{{ $restaurant->user->email }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $restaurant->phone }}</div>
                            <div class="text-sm text-gray-500">{{ $restaurant->email }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($restaurant->status === 'active')
                                <span class="px-3 py-1 bg-green-100 text-green-800 text-xs rounded-full font-medium">Active</span>
                            @else
                                <span class="px-3 py-1 bg-gray-100 text-gray-800 text-xs rounded-full font-medium">Inactive</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('admin.restaurants.show', $restaurant) }}"
                                   class="text-primary-600 hover:text-primary-900 transition" title="View Details">
                                    <i class='bx bx-show text-lg'></i>
                                </a>

                                <!-- Status Toggle -->
                                <form action="{{ route('admin.restaurants.status', $restaurant) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="{{ $restaurant->status === 'active' ? 'inactive' : 'active' }}">
                                    <button type="submit"
                                            class="text-{{ $restaurant->status === 'active' ? 'orange' : 'green' }}-600 hover:text-{{ $restaurant->status === 'active' ? 'orange' : 'green' }}-900 transition"
                                            title="{{ $restaurant->status === 'active' ? 'Deactivate' : 'Activate' }}">
                                        <i class='bx bx-{{ $restaurant->status === 'active' ? 'pause' : 'play' }} text-lg'></i>
                                    </button>
                                </form>

                                <!-- Delete -->
                                <form action="{{ route('admin.restaurants.destroy', $restaurant) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="text-red-600 hover:text-red-900 transition"
                                            title="Delete Restaurant"
                                            onclick="return confirm('Are you sure you want to delete this restaurant?')">
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
            {{ $restaurants->links() }}
        </div>
    </div>
</div>
@endsection
