@extends('layouts.owner')

@section('title', 'Create Restaurant')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center space-x-4 mb-4">
            <a href="{{ route('owner.dashboard') }}" class="text-gray-400 hover:text-gray-600 transition">
                <i class='bx bx-arrow-back text-2xl'></i>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Create Your Restaurant</h1>
                <p class="text-gray-600">Setup your restaurant profile to start accepting orders</p>
            </div>
        </div>

        <!-- Progress Steps -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="grid grid-cols-3 gap-4">
                <div class="text-center">
                    <div class="w-10 h-10 bg-accent-amber rounded-full flex items-center justify-center mx-auto mb-2">
                        <i class='bx bx-store text-white'></i>
                    </div>
                    <p class="text-sm font-medium text-gray-900">Restaurant Info</p>
                    <p class="text-xs text-gray-500">Step 1</p>
                </div>
                <div class="text-center">
                    <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-2">
                        <i class='bx bx-food-menu text-gray-500'></i>
                    </div>
                    <p class="text-sm font-medium text-gray-500">Add Menu</p>
                    <p class="text-xs text-gray-400">Step 2</p>
                </div>
                <div class="text-center">
                    <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-2">
                        <i class='bx bx-cog text-gray-500'></i>
                    </div>
                    <p class="text-sm font-medium text-gray-500">Settings</p>
                    <p class="text-xs text-gray-400">Step 3</p>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('owner.restaurants.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <!-- Restaurant Images Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <i class='bx bx-image mr-2'></i>
                Restaurant Images
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Logo Upload -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Restaurant Logo
                    </label>
                    <div class="space-y-3">
                        <!-- Logo Preview -->
                        <div id="logoPreview" class="hidden">
                            <div class="w-32 h-32 border-2 border-dashed border-gray-300 rounded-xl bg-gray-50 flex items-center justify-center overflow-hidden">
                                <img id="logoPreviewImage" class="w-full h-full object-contain" alt="Logo preview">
                            </div>
                        </div>

                        <!-- Upload Area -->
                        <div id="logoUploadArea" class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-gray-400 transition cursor-pointer">
                            <input type="file" id="logo" name="logo" accept="image/*" class="hidden" onchange="previewLogo(event)">
                            <i class='bx bx-cloud-upload text-3xl text-gray-400 mb-2'></i>
                            <p class="text-sm text-gray-600">Click to upload logo</p>
                            <p class="text-xs text-gray-500 mt-1">PNG, JPG, GIF up to 2MB</p>
                        </div>

                        <!-- Upload Button -->
                        <button type="button" onclick="document.getElementById('logo').click()"
                                class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 py-2 px-4 rounded-xl font-medium transition flex items-center justify-center space-x-2">
                            <i class='bx bx-upload'></i>
                            <span>Choose Logo</span>
                        </button>
                    </div>
                    @error('logo')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Cover Image Upload -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Cover Image
                    </label>
                    <div class="space-y-3">
                        <!-- Cover Preview -->
                        <div id="coverPreview" class="hidden">
                            <div class="w-full h-32 border-2 border-dashed border-gray-300 rounded-xl bg-gray-50 flex items-center justify-center overflow-hidden">
                                <img id="coverPreviewImage" class="w-full h-full object-cover" alt="Cover preview">
                            </div>
                        </div>

                        <!-- Upload Area -->
                        <div id="coverUploadArea" class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-gray-400 transition cursor-pointer">
                            <input type="file" id="cover_image" name="cover_image" accept="image/*" class="hidden" onchange="previewCover(event)">
                            <i class='bx bx-cloud-upload text-3xl text-gray-400 mb-2'></i>
                            <p class="text-sm text-gray-600">Click to upload cover</p>
                            <p class="text-xs text-gray-500 mt-1">PNG, JPG, GIF up to 5MB</p>
                        </div>

                        <!-- Upload Button -->
                        <button type="button" onclick="document.getElementById('cover_image').click()"
                                class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 py-2 px-4 rounded-xl font-medium transition flex items-center justify-center space-x-2">
                            <i class='bx bx-upload'></i>
                            <span>Choose Cover</span>
                        </button>
                    </div>
                    @error('cover_image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Restaurant Information Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <i class='bx bx-info-circle mr-2'></i>
                Restaurant Information
            </h3>

            <div class="space-y-6">
                <!-- Restaurant Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Restaurant Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition"
                           placeholder="e.g., Warung Enak Sejahtera">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Description <span class="text-red-500">*</span>
                    </label>
                    <textarea id="description" name="description" rows="3" required
                              class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition"
                              placeholder="Describe your restaurant, specialties, and what makes it unique">{{ old('description') }}</textarea>
                    <div class="flex justify-between items-center mt-1">
                        <p class="text-sm text-gray-500">Brief description that appears to customers</p>
                        <span id="charCount" class="text-sm text-gray-500">0/500</span>
                    </div>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Contact & Location Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <i class='bx bx-map mr-2'></i>
                Contact & Location
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Address -->
                <div class="md:col-span-2">
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                        Complete Address <span class="text-red-500">*</span>
                    </label>
                    <textarea id="address" name="address" rows="2" required
                              class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition"
                              placeholder="Full address including street, city, and postal code">{{ old('address') }}</textarea>
                    @error('address')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                        Phone Number <span class="text-red-500">*</span>
                    </label>
                    <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition"
                           placeholder="e.g., 081234567890">
                    @error('phone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Email Address
                    </label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition"
                           placeholder="restaurant@email.com">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Tips & Guidelines -->
        <div class="bg-blue-50 border border-blue-200 rounded-2xl p-6">
            <h3 class="font-semibold text-blue-900 mb-3 flex items-center">
                <i class='bx bx-info-circle mr-2'></i>
                Tips for Success
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-blue-800">
                <div class="flex items-start space-x-2">
                    <i class='bx bx-check-shield mt-0.5'></i>
                    <span>Use a clear, high-quality logo that represents your brand</span>
                </div>
                <div class="flex items-start space-x-2">
                    <i class='bx bx-check-shield mt-0.5'></i>
                    <span>Choose a cover image that showcases your restaurant's atmosphere</span>
                </div>
                <div class="flex items-start space-x-2">
                    <i class='bx bx-check-shield mt-0.5'></i>
                    <span>Write an engaging description that highlights your specialties</span>
                </div>
                <div class="flex items-start space-x-2">
                    <i class='bx bx-check-shield mt-0.5'></i>
                    <span>Ensure your address is accurate for delivery services</span>
                </div>
            </div>
        </div>

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

        <!-- Form Actions -->
        <div class="flex items-center justify-between pt-6 border-t border-gray-100">
            <a href="{{ route('owner.dashboard') }}"
               class="px-6 py-3 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition font-medium flex items-center space-x-2">
                <i class='bx bx-arrow-back'></i>
                <span>Back to Dashboard</span>
            </a>
            <button type="submit"
                    class="bg-accent-amber hover:bg-orange-600 text-white px-8 py-3 rounded-xl font-medium transition flex items-center space-x-2">
                <i class='bx bx-check'></i>
                <span>Create Restaurant</span>
            </button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Character counter for description
        const description = document.getElementById('description');
        const charCount = document.getElementById('charCount');

        function updateCharCount() {
            const length = description.value.length;
            charCount.textContent = `${length}/500`;

            if (length > 500) {
                charCount.classList.add('text-red-600');
                charCount.classList.remove('text-gray-500');
            } else {
                charCount.classList.remove('text-red-600');
                charCount.classList.add('text-gray-500');
            }
        }

        description.addEventListener('input', updateCharCount);
        updateCharCount(); // Initial call

        // Form submission validation
        const form = document.querySelector('form');
        form.addEventListener('submit', function(e) {
            const descriptionLength = description.value.length;
            if (descriptionLength > 500) {
                e.preventDefault();
                alert('Description cannot exceed 500 characters.');
                description.focus();
            }
        });
    });

    // Logo preview functionality
    function previewLogo(event) {
        const input = event.target;
        const preview = document.getElementById('logoPreview');
        const previewImage = document.getElementById('logoPreviewImage');
        const uploadArea = document.getElementById('logoUploadArea');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                previewImage.src = e.target.result;
                preview.classList.remove('hidden');
                uploadArea.classList.add('hidden');
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    // Cover image preview functionality
    function previewCover(event) {
        const input = event.target;
        const preview = document.getElementById('coverPreview');
        const previewImage = document.getElementById('coverPreviewImage');
        const uploadArea = document.getElementById('coverUploadArea');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                previewImage.src = e.target.result;
                preview.classList.remove('hidden');
                uploadArea.classList.add('hidden');
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    // Drag and drop functionality
    function setupDragAndDrop(uploadAreaId, inputId, previewId, previewImageId) {
        const uploadArea = document.getElementById(uploadAreaId);
        const input = document.getElementById(inputId);
        const preview = document.getElementById(previewId);
        const previewImage = document.getElementById(previewImageId);

        // Prevent default drag behaviors
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            uploadArea.addEventListener(eventName, preventDefaults, false);
            document.body.addEventListener(eventName, preventDefaults, false);
        });

        // Highlight drop area when item is dragged over it
        ['dragenter', 'dragover'].forEach(eventName => {
            uploadArea.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            uploadArea.addEventListener(eventName, unhighlight, false);
        });

        // Handle dropped files
        uploadArea.addEventListener('drop', handleDrop, false);

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        function highlight() {
            uploadArea.classList.add('border-primary-500', 'bg-primary-50');
        }

        function unhighlight() {
            uploadArea.classList.remove('border-primary-500', 'bg-primary-50');
        }

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            input.files = files;

            // Trigger the change event
            const event = new Event('change', { bubbles: true });
            input.dispatchEvent(event);
        }
    }

    // Initialize drag and drop for both logo and cover
    document.addEventListener('DOMContentLoaded', function() {
        setupDragAndDrop('logoUploadArea', 'logo', 'logoPreview', 'logoPreviewImage');
        setupDragAndDrop('coverUploadArea', 'cover_image', 'coverPreview', 'coverPreviewImage');
    });
</script>
@endsection
