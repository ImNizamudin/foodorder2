@extends('layouts.owner')

@section('title', 'Add Menu Item')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center space-x-4 mb-4">
            <a href="{{ route('owner.menu-items.index') }}" class="text-gray-400 hover:text-gray-600 transition">
                <i class='bx bx-arrow-back text-2xl'></i>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Add Menu Item</h1>
                <p class="text-gray-600">Create a new menu item for your restaurant</p>
            </div>
        </div>
    </div>

    <form action="{{ route('owner.menu-items.store') }}" method="POST" class="space-y-6" enctype="multipart/form-data">
        @csrf

        <!-- Basic Information Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <i class='bx bx-info-circle mr-2'></i>
                Basic Information
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Item Name -->
                <div class="md:col-span-2">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Item Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition"
                           placeholder="e.g., Nasi Goreng Special">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Description
                    </label>
                    <textarea id="description" name="description" rows="3"
                              class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition"
                              placeholder="Describe your menu item...">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Price -->
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                        Price <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">Rp</span>
                        <input type="number" id="price" name="price" value="{{ old('price') }}" required min="1000" step="500"
                               class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition"
                               placeholder="25000">
                    </div>
                    @error('price')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Category -->
                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Category <span class="text-red-500">*</span>
                    </label>
                    <select id="category_id" name="category_id" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition">
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- ✅ TAMBAHKAN IMAGE UPLOAD CARD -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <i class='bx bx-image mr-2'></i>
                Item Image
            </h3>

            <div class="space-y-4">
                <!-- Image Upload -->
                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                        Upload Image
                    </label>
                    <input type="file" id="image" name="image" accept="image/*"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition">
                    <p class="mt-1 text-sm text-gray-500">Format: JPG, PNG, JPEG (max 2MB)</p>
                    @error('image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Image Preview -->
                <div id="imagePreview" class="hidden">
                    <p class="text-sm font-medium text-gray-700 mb-2">Preview:</p>
                    <div class="w-32 h-32 border-2 border-dashed border-gray-300 rounded-xl overflow-hidden">
                        <img id="previewImage" class="w-full h-full object-cover" src="" alt="Preview">
                    </div>
                </div>
            </div>
        </div>

        <!-- Availability Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <i class='bx bx-cog mr-2'></i>
                Availability Settings
            </h3>

            <div class="flex items-center justify-between">
                <div>
                    <p class="font-medium text-gray-900">Item Availability</p>
                    <p class="text-sm text-gray-600">Make this item available for ordering</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="is_available" value="1" class="sr-only peer" checked>
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary-600"></div>
                </label>
            </div>
            @error('is_available')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Success/Error Messages -->
        @if($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-2xl p-4">
                <div class="flex items-center">
                    <i class='bx bx-error-alt text-red-600 text-xl mr-3'></i>
                    <div>
                        <p class="text-red-800 font-medium">Please fix the following errors:</p>
                        <ul class="text-red-700 text-sm mt-1 list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <!-- Form Actions -->
        <div class="flex items-center justify-between pt-6 border-t border-gray-100">
            <a href="{{ route('owner.menu-items.index') }}"
               class="px-6 py-3 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition font-medium flex items-center space-x-2">
                <i class='bx bx-arrow-back'></i>
                <span>Back to Menu</span>
            </a>
            <button type="submit"
                    class="bg-accent-amber hover:bg-orange-600 text-white px-8 py-3 rounded-xl font-medium transition flex items-center space-x-2">
                <i class='bx bx-check'></i>
                <span>Create Menu Item</span>
            </button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Image preview functionality
        const imageInput = document.getElementById('image');
        const imagePreview = document.getElementById('imagePreview');
        const previewImage = document.getElementById('previewImage');

        imageInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();

                reader.addEventListener('load', function() {
                    previewImage.setAttribute('src', this.result);
                    imagePreview.classList.remove('hidden');
                });

                reader.readAsDataURL(file);
            } else {
                imagePreview.classList.add('hidden');
            }
        });

        // ✅ HAPUS SCRIPT FORMATTING PRICE YANG MENYEBABKAN FOCUS ISSUE
        // const priceInput = document.getElementById('price');
        // priceInput.addEventListener('blur', function() {
        //     if (this.value) {
        //         this.value = parseInt(this.value).toLocaleString('id-ID');
        //     }
        // });

        // priceInput.addEventListener('focus', function() {
        //     this.value = this.value.replace(/\./g, '');
        // });
    });
</script>
@endsection
