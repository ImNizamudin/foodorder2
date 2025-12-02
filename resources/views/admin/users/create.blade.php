@extends('layouts.admin')

@section('title', 'Add New User')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
        <!-- Header -->
        <div class="p-6 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Add New User</h1>
                    <p class="text-gray-600">Create a new user account</p>
                </div>
                <a href="{{ route('admin.users') }}" class="text-gray-400 hover:text-gray-600 transition">
                    <i class='bx bx-x text-2xl'></i>
                </a>
            </div>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('admin.users.store') }}" class="p-6 space-y-6">
            @csrf

            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition">
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Phone -->
            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" required
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition">
                @error('phone')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Role Selection -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-3">Role</label>
                <div class="grid grid-cols-3 gap-4">
                    @foreach(['customer' => 'Customer', 'owner' => 'Restaurant Owner', 'admin' => 'Admin'] as $value => $label)
                    <label class="relative flex cursor-pointer">
                        <input type="radio" name="role" value="{{ $value }}" class="sr-only"
                               {{ old('role', 'customer') === $value ? 'checked' : '' }}>
                        <div class="role-card w-full border-2 border-gray-300 rounded-xl p-4 text-center hover:border-primary-500 transition duration-200 group">
                            <div class="w-8 h-8 mx-auto mb-2 rounded-lg flex items-center justify-center
                                @if($value === 'customer') bg-blue-100 group-hover:bg-blue-200
                                @elseif($value === 'owner') bg-green-100 group-hover:bg-green-200
                                @else bg-purple-100 group-hover:bg-purple-200 @endif">
                                <i class='bx
                                    @if($value === 'customer') bx-user text-blue-600
                                    @elseif($value === 'owner') bx-store-alt text-green-600
                                    @else bx-shield-alt text-purple-600 @endif
                                '></i>
                            </div>
                            <span class="text-sm font-medium text-gray-700">{{ $label }}</span>
                        </div>
                    </label>
                    @endforeach
                </div>
                @error('role')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                <input type="password" id="password" name="password" required
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition">
                @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition">
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-100">
                <a href="{{ route('admin.users') }}" class="px-6 py-3 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition font-medium">
                    Cancel
                </a>
                <button type="submit" class="bg-primary-500 hover:bg-primary-600 text-white px-6 py-3 rounded-xl font-medium transition">
                    Create User
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const roleCards = document.querySelectorAll('.role-card');
        const radioInputs = document.querySelectorAll('input[name="role"]');

        function updateRoleSelection() {
            roleCards.forEach((card, index) => {
                const radio = radioInputs[index];
                if (radio.checked) {
                    card.classList.add('border-primary-500', 'bg-primary-50');
                } else {
                    card.classList.remove('border-primary-500', 'bg-primary-50');
                }
            });
        }

        roleCards.forEach((card, index) => {
            card.addEventListener('click', function() {
                radioInputs[index].checked = true;
                updateRoleSelection();
            });
        });

        // Initialize selection
        updateRoleSelection();
    });
</script>

<style>
    .role-card {
        transition: all 0.2s ease-in-out;
    }
    .role-card:hover {
        transform: translateY(-2px);
    }
</style>
@endsection
