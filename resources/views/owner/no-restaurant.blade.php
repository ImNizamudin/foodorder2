@extends('layouts.owner')

@section('title', $title)

@section('content')
<div class="min-h-screen flex items-center justify-center py-12">
    <div class="max-w-md w-full text-center">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
            <!-- Icon -->
            <div class="w-20 h-20 bg-gradient-to-r from-accent-amber to-orange-500 rounded-2xl flex items-center justify-center mx-auto mb-6">
                <i class='bx bx-store text-3xl text-white'></i>
            </div>

            <!-- Content -->
            <h1 class="text-2xl font-bold text-gray-900 mb-4">Setup Your Restaurant</h1>
            <p class="text-gray-600 mb-6">
                You haven't set up your restaurant yet. Let's get started by creating your restaurant profile to start accepting orders.
            </p>

            <!-- Stats -->
            <div class="grid grid-cols-3 gap-4 mb-8">
                <div class="text-center p-3 bg-blue-50 rounded-xl">
                    <p class="text-2xl font-bold text-blue-600">1</p>
                    <p class="text-xs text-blue-600">Setup</p>
                </div>
                <div class="text-center p-3 bg-gray-100 rounded-xl">
                    <p class="text-2xl font-bold text-gray-400">2</p>
                    <p class="text-xs text-gray-500">Add Menu</p>
                </div>
                <div class="text-center p-3 bg-gray-100 rounded-xl">
                    <p class="text-2xl font-bold text-gray-400">3</p>
                    <p class="text-xs text-gray-500">Receive Orders</p>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="space-y-3">
                <a href="{{ route('owner.restaurants.create') }}"
                   class="w-full bg-accent-amber hover:bg-orange-600 text-white py-3 px-6 rounded-xl font-medium transition flex items-center justify-center space-x-2">
                    <i class='bx bx-plus'></i>
                    <span>Create Restaurant</span>
                </a>

                <button class="w-full border border-gray-300 text-gray-700 py-3 px-6 rounded-xl font-medium transition hover:bg-gray-50 flex items-center justify-center space-x-2">
                    <i class='bx bx-help-circle'></i>
                    <span>Need Help?</span>
                </button>
            </div>

            <!-- Tips -->
            <div class="mt-8 p-4 bg-primary-50 rounded-xl border border-primary-200">
                <h3 class="font-semibold text-primary-900 mb-2">Quick Tips</h3>
                <ul class="text-sm text-primary-700 space-y-1 text-left">
                    <li>• Prepare your restaurant information and photos</li>
                    <li>• Have your menu items ready with prices</li>
                    <li>• Set your operating hours</li>
                    <li>• Prepare your bank account for payments</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
