@extends('layouts.owner')

@section('title', 'Menu Management')

@section('content')
<div class="space-y-6">
    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 rounded-2xl p-4">
            <div class="flex items-center">
                <i class='bx bx-check-circle text-green-600 text-xl mr-3'></i>
                <p class="text-green-800 font-medium">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 border border-red-200 rounded-2xl p-4">
            <div class="flex items-center">
                <i class='bx bx-error-alt text-red-600 text-xl mr-3'></i>
                <p class="text-red-800 font-medium">{{ session('error') }}</p>
            </div>
        </div>
    @endif

    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Menu Management</h1>
            <p class="text-gray-600">Manage your restaurant menu items</p>
        </div>

        <a href="{{ route('owner.menu-items.create') }}"
           class="bg-accent-amber hover:bg-orange-600 text-white px-6 py-3 rounded-xl font-medium transition flex items-center space-x-2">
            <i class='bx bx-plus'></i>
            <span>Add Menu Item</span>
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="stat-card bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Total Items</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $menuItems->total() }}</p>
                </div>
                <div class="w-14 h-14 bg-primary-100 rounded-2xl flex items-center justify-center">
                    <i class='bx bx-food-menu text-2xl text-primary-600'></i>
                </div>
            </div>
        </div>

        <div class="stat-card bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Available</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $menuItems->where('is_available', true)->count() }}</p>
                </div>
                <div class="w-14 h-14 bg-green-100 rounded-2xl flex items-center justify-center">
                    <i class='bx bx-check-circle text-2xl text-green-600'></i>
                </div>
            </div>
        </div>

        <div class="stat-card bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Categories</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $categories->count() }}</p>
                </div>
                <div class="w-14 h-14 bg-blue-100 rounded-2xl flex items-center justify-center">
                    <i class='bx bx-category text-2xl text-blue-600'></i>
                </div>
            </div>
        </div>

        <div class="stat-card bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Avg Price</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">Rp {{ number_format($menuItems->avg('price') ?? 0, 0, ',', '.') }}</p>
                </div>
                <div class="w-14 h-14 bg-purple-100 rounded-2xl flex items-center justify-center">
                    <i class='bx bx-dollar-circle text-2xl text-purple-600'></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters & Search -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex items-center space-x-4">
                <!-- Search -->
                <div class="relative">
                    <i class='bx bx-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400'></i>
                    <input type="text" placeholder="Search menu items..."
                           class="pl-10 pr-4 py-2 border border-gray-300 rounded-xl focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition">
                </div>

                <!-- Category Filter -->
                <select class="px-4 py-2 border border-gray-300 rounded-xl focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>

                <!-- Availability Filter -->
                <select class="px-4 py-2 border border-gray-300 rounded-xl focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition">
                    <option value="">All Status</option>
                    <option value="available">Available</option>
                    <option value="unavailable">Unavailable</option>
                </select>
            </div>

            <div class="flex items-center space-x-2">
                <button class="px-4 py-2 border border-gray-300 rounded-xl hover:bg-gray-50 transition flex items-center space-x-2">
                    <i class='bx bx-filter'></i>
                    <span>Filter</span>
                </button>
                <button class="px-4 py-2 border border-gray-300 rounded-xl hover:bg-gray-50 transition flex items-center space-x-2">
                    <i class='bx bx-sort'></i>
                    <span>Sort</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Menu Items Grid -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <!-- Table Header -->
        <div class="border-b border-gray-200">
            <div class="grid grid-cols-12 gap-4 px-6 py-4 bg-gray-50">
                <div class="col-span-5 font-semibold text-gray-900">Item</div>
                <div class="col-span-2 font-semibold text-gray-900">Category</div>
                <div class="col-span-2 font-semibold text-gray-900">Price</div>
                <div class="col-span-2 font-semibold text-gray-900">Status</div>
                <div class="col-span-1 font-semibold text-gray-900 text-center">Actions</div>
            </div>
        </div>

        <!-- Table Body -->
        <div class="divide-y divide-gray-100">
            @forelse($menuItems as $item)
            <div class="grid grid-cols-12 gap-4 px-6 py-4 hover:bg-gray-50 transition">
                <!-- Item Info -->
                <div class="col-span-5">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-gradient-to-r from-primary-500 to-primary-600 rounded-xl flex items-center justify-center">
                            @if($item->image)
                                <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" class="w-10 h-10 rounded-lg object-cover">
                            @else
                                <i class='bx bx-food-menu text-white text-lg'></i>
                            @endif
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">{{ $item->name }}</p>
                            <p class="text-gray-600 text-sm line-clamp-1">{{ Str::limit($item->description, 50) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Category -->
                <div class="col-span-2 flex items-center">
                    <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                        {{ $item->category->name ?? 'Uncategorized' }}
                    </span>
                </div>

                <!-- Price -->
                <div class="col-span-2 flex items-center">
                    <span class="font-semibold text-gray-900">{{ $item->formatted_price }}</span>
                </div>

                <!-- Status -->
                <div class="col-span-2 flex items-center">
                    @if($item->is_available)
                        <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium flex items-center space-x-1">
                            <i class='bx bx-check'></i>
                            <span>Available</span>
                        </span>
                    @else
                        <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm font-medium flex items-center space-x-1">
                            <i class='bx bx-x'></i>
                            <span>Unavailable</span>
                        </span>
                    @endif
                </div>

                <!-- Actions -->
                <div class="col-span-1 flex items-center justify-center space-x-2">
                    <!-- Toggle Availability -->
                    <form action="{{ route('owner.menu-items.toggle-availability', $item) }}" method="POST" class="inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                                class="text-gray-400 hover:text-green-600 transition tooltip"
                                title="{{ $item->is_available ? 'Mark as Unavailable' : 'Mark as Available' }}">
                            <i class='bx bx-{{ $item->is_available ? "check" : "x" }} text-lg'></i>
                        </button>
                    </form>

                    <!-- Edit -->
                    <a href="{{ route('owner.menu-items.edit', $item) }}"
                    class="text-gray-400 hover:text-blue-600 transition tooltip"
                    title="Edit">
                        <i class='bx bx-edit text-lg'></i>
                    </a>

                    <!-- Delete -->
                    <form action="{{ route('owner.menu-items.destroy', $item) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="text-gray-400 hover:text-red-600 transition tooltip"
                                title="Delete"
                                onclick="return confirm('Are you sure you want to delete {{ $item->name }}?')">
                            <i class='bx bx-trash text-lg'></i>
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <!-- Empty State -->
            <div class="px-6 py-12 text-center">
                <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class='bx bx-food-menu text-2xl text-gray-400'></i>
                </div>
                <h4 class="text-lg font-medium text-gray-900 mb-2">No Menu Items Yet</h4>
                <p class="text-gray-600 mb-6">Start by adding your first menu item to your restaurant.</p>
                <a href="{{ route('owner.menu-items.create') }}"
                   class="bg-accent-amber hover:bg-orange-600 text-white px-6 py-3 rounded-xl font-medium transition inline-flex items-center space-x-2">
                    <i class='bx bx-plus'></i>
                    <span>Add Your First Item</span>
                </a>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($menuItems->hasPages())
        <div class="border-t border-gray-200 px-6 py-4">
            {{ $menuItems->links() }}
        </div>
        @endif
    </div>

    <!-- Quick Actions -->
    {{-- <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('owner.menu-items.create') }}" class="p-4 rounded-xl bg-primary-50 border border-primary-200 hover:bg-primary-100 transition group">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-primary-500 rounded-xl flex items-center justify-center">
                        <i class='bx bx-plus text-white'></i>
                    </div>
                    <div>
                        <p class="font-semibold text-primary-900">Add Menu Item</p>
                        <p class="text-primary-700 text-sm">Create new menu item</p>
                    </div>
                </div>
            </a>

            <button class="p-4 rounded-xl bg-blue-50 border border-blue-200 hover:bg-blue-100 transition group">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-blue-500 rounded-xl flex items-center justify-center">
                        <i class='bx bx-category text-white'></i>
                    </div>
                    <div>
                        <p class="font-semibold text-blue-900">Manage Categories</p>
                        <p class="text-blue-700 text-sm">Organize menu categories</p>
                    </div>
                </div>
            </button>

            <button class="p-4 rounded-xl bg-green-50 border border-green-200 hover:bg-green-100 transition group">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-green-500 rounded-xl flex items-center justify-center">
                        <i class='bx bx-cloud-upload text-white'></i>
                    </div>
                    <div>
                        <p class="font-semibold text-green-900">Bulk Upload</p>
                        <p class="text-green-700 text-sm">Upload multiple items</p>
                    </div>
                </div>
            </button>
        </div>
    </div> --}}
</div>

<style>
    .line-clamp-1 {
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
    }
</style>
@endsection
