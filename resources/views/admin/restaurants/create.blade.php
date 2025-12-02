@extends('layouts.admin')

@section('title', 'Add New Restaurant')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
        <!-- Header -->
        <div class="p-6 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Add New Restaurant</h1>
                    <p class="text-gray-600">Register a new restaurant on the platform</p>
                </div>
                <a href="{{ route('admin.restaurants') }}" class="text-gray-400 hover:text-gray-600 transition">
                    <i class='bx bx-x text-2xl'></i>
                </a>
            </div>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('admin.restaurants.store') }}" class="p-6 space-y-6">
            @csrf

            <!-- Restaurant Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Restaurant Name</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition"
                       placeholder="Enter restaurant name">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <textarea id="description" name="description" rows="3"
                          class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition"
                          placeholder="Brief description about the restaurant">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Address -->
            <div>
                <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                <textarea id="address" name="address" rows="2" required
                          class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition"
                          placeholder="Full restaurant address">{{ old('address') }}</textarea>
                @error('address')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Contact Information -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                    <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition"
                           placeholder="Phone number">
                    @error('phone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email (Optional)</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition"
                           placeholder="restaurant@email.com">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Owner Selection -->
            <div>
                <label for="user_id" class="block text-sm font-medium text-gray-700 mb-2">Restaurant Owner</label>
                <select id="user_id" name="user_id" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition">
                    <option value="">Select an owner</option>
                    @foreach($owners as $owner)
                        <option value="{{ $owner->id }}" {{ old('user_id') == $owner->id ? 'selected' : '' }}>
                            {{ $owner->name }} ({{ $owner->email }})
                        </option>
                    @endforeach
                </select>
                @error('user_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror

                @if($owners->isEmpty())
                <p class="mt-2 text-sm text-orange-600">
                    No restaurant owners found.
                    <a href="{{ route('admin.users.create') }}" class="text-primary-600 hover:text-primary-700 font-medium">
                        Create an owner account first.
                    </a>
                </p>
                @endif
            </div>

            <!-- Status -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-3">Status</label>
                <div class="grid grid-cols-2 gap-4">
                    <label class="relative flex cursor-pointer">
                        <input type="radio" name="status" value="active" class="sr-only" checked>
                        <div class="status-card w-full border-2 border-gray-300 rounded-xl p-4 text-center hover:border-green-500 transition duration-200 group">
                            <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mx-auto mb-2 group-hover:bg-green-200">
                                <i class='bx bx-check text-green-600'></i>
                            </div>
                            <span class="text-sm font-medium text-gray-700">Active</span>
                            <p class="text-xs text-gray-500 mt-1">Ready for orders</p>
                        </div>
                    </label>

                    <label class="relative flex cursor-pointer">
                        <input type="radio" name="status" value="inactive" class="sr-only">
                        <div class="status-card w-full border-2 border-gray-300 rounded-xl p-4 text-center hover:border-gray-500 transition duration-200 group">
                            <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center mx-auto mb-2 group-hover:bg-gray-200">
                                <i class='bx bx-pause text-gray-600'></i>
                            </div>
                            <span class="text-sm font-medium text-gray-700">Inactive</span>
                            <p class="text-xs text-gray-500 mt-1">Not taking orders</p>
                        </div>
                    </label>
                </div>
                @error('status')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-100">
                <a href="{{ route('admin.restaurants') }}" class="px-6 py-3 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition font-medium">
                    Cancel
                </a>
                <button type="submit" class="bg-primary-500 hover:bg-primary-600 text-white px-6 py-3 rounded-xl font-medium transition">
                    Create Restaurant
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Status selection
        const statusCards = document.querySelectorAll('.status-card');
        const statusInputs = document.querySelectorAll('input[name="status"]');

        function updateStatusSelection() {
            statusCards.forEach((card, index) => {
                const radio = statusInputs[index];
                if (radio.checked) {
                    if (radio.value === 'active') {
                        card.classList.add('border-green-500', 'bg-green-50');
                    } else {
                        card.classList.add('border-gray-500', 'bg-gray-50');
                    }
                } else {
                    card.classList.remove('border-green-500', 'bg-green-50', 'border-gray-500', 'bg-gray-50');
                }
            });
        }

        statusCards.forEach((card, index) => {
            card.addEventListener('click', function() {
                statusInputs[index].checked = true;
                updateStatusSelection();
            });
        });

        // Initialize selection
        updateStatusSelection();
    });
</script>

<style>
    .status-card {
        transition: all 0.2s ease-in-out;
    }
    .status-card:hover {
        transform: translateY(-2px);
    }
</style>
@endsection
