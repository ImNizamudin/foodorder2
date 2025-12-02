@extends('layouts.owner')

@section('title', $title)

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
        <!-- Header -->
        <div class="p-6 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('owner.dashboard') }}" class="text-gray-400 hover:text-gray-600 transition">
                        <i class='bx bx-arrow-back text-2xl'></i>
                    </a>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Restaurant Settings</h1>
                        <p class="text-gray-600">Update your restaurant information</p>
                    </div>
                </div>
                <div class="text-right">
                    <div class="flex items-center space-x-2 text-sm">
                        <span class="px-2 py-1 rounded-full text-xs font-medium capitalize
                            @if($restaurant->status === 'active')
                                bg-green-100 text-green-800
                            @else
                                bg-gray-100 text-gray-800
                            @endif">
                            {{ $restaurant->status }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('owner.restaurants.update') }}" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 rounded-xl p-4 mb-6">
                    <div class="flex items-center">
                        <i class='bx bx-check-circle text-green-600 text-xl mr-3'></i>
                        <p class="text-green-800 font-medium">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-6">
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

            <!-- Restaurant Images Card -->
            <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
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
                            <!-- Current Logo Preview -->
                            @if($restaurant->logo)
                                <div id="currentLogo" class="mb-3">
                                    <p class="text-sm text-gray-600 mb-2">Current Logo:</p>
                                    <div class="w-32 h-32 border-2 border-gray-200 rounded-xl bg-white flex items-center justify-center overflow-hidden">
                                        <img src="{{ asset('storage/' . $restaurant->logo) }}" class="w-full h-full object-contain" alt="Current logo">
                                    </div>
                                    <button type="button" onclick="removeImage('logo')" class="mt-2 text-red-600 hover:text-red-800 text-sm font-medium flex items-center space-x-1">
                                        <i class='bx bx-trash'></i>
                                        <span>Remove Logo</span>
                                    </button>
                                </div>
                            @endif

                            <!-- Logo Preview -->
                            <div id="logoPreview" class="hidden">
                                <p class="text-sm text-gray-600 mb-2">New Logo Preview:</p>
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
                                <span>Choose New Logo</span>
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
                            <!-- Current Cover Preview -->
                            @if($restaurant->cover_image)
                                <div id="currentCover" class="mb-3">
                                    <p class="text-sm text-gray-600 mb-2">Current Cover:</p>
                                    <div class="w-full h-32 border-2 border-gray-200 rounded-xl bg-white flex items-center justify-center overflow-hidden">
                                        <img src="{{ asset('storage/' . $restaurant->cover_image) }}" class="w-full h-full object-cover" alt="Current cover">
                                    </div>
                                    <button type="button" onclick="removeImage('cover')" class="mt-2 text-red-600 hover:text-red-800 text-sm font-medium flex items-center space-x-1">
                                        <i class='bx bx-trash'></i>
                                        <span>Remove Cover</span>
                                    </button>
                                </div>
                            @endif

                            <!-- Cover Preview -->
                            <div id="coverPreview" class="hidden">
                                <p class="text-sm text-gray-600 mb-2">New Cover Preview:</p>
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
                                <span>Choose New Cover</span>
                            </button>
                        </div>
                        @error('cover_image')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Restaurant Info Card -->
            <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class='bx bx-info-circle mr-2'></i>
                    Basic Information
                </h3>

                <!-- Restaurant Name -->
                <div class="mb-6">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Restaurant Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="name" name="name" value="{{ old('name', $restaurant->name) }}" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="mb-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Description <span class="text-red-500">*</span>
                    </label>
                    <textarea id="description" name="description" rows="3" required
                              class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition">{{ old('description', $restaurant->description) }}</textarea>
                    <div class="flex justify-between items-center mt-1">
                        <p class="text-sm text-gray-500">Brief description that appears to customers</p>
                        <span id="charCount" class="text-sm text-gray-500">{{ strlen($restaurant->description) }}/500</span>
                    </div>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Address -->
                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                        Complete Address <span class="text-red-500">*</span>
                    </label>
                    <textarea id="address" name="address" rows="2" required
                              class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition">{{ old('address', $restaurant->address) }}</textarea>
                    @error('address')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Contact Information Card -->
            <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class='bx bx-phone mr-2'></i>
                    Contact Information
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                            Phone Number <span class="text-red-500">*</span>
                        </label>
                        <input type="tel" id="phone" name="phone" value="{{ old('phone', $restaurant->phone) }}" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition">
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email Address
                        </label>
                        <input type="email" id="email" name="email" value="{{ old('email', $restaurant->email) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Restaurant Status Card -->
            <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class='bx bx-cog mr-2'></i>
                    Restaurant Status
                </h3>

                <div class="flex items-center justify-between">
                    <div>
                        <p class="font-medium text-gray-900">Current Status</p>
                        <p class="text-sm text-gray-600">
                            @if($restaurant->status === 'active')
                                Your restaurant is active and accepting orders
                            @else
                                Your restaurant is inactive and not taking orders
                            @endif
                        </p>
                    </div>
                    <div class="text-right">
                        <span class="px-3 py-2 rounded-lg font-medium capitalize
                            @if($restaurant->status === 'active')
                                bg-green-100 text-green-800
                            @else
                                bg-gray-100 text-gray-800
                            @endif">
                            {{ $restaurant->status }}
                        </span>
                        <p class="text-xs text-gray-500 mt-1">You can toggle your restaurant status</p>
                    </div>
                </div>

                <!-- Toggle Status Button -->
                <div class="mt-4 pt-4 border-t border-gray-200">
                    @if($restaurant->status === 'active')
                        <button type="button" onclick="toggleRestaurantStatus('inactive')"
                                class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg font-medium transition text-sm flex items-center space-x-2">
                            <i class='bx bx-power-off'></i>
                            <span>Deactivate Restaurant</span>
                        </button>
                        <p class="text-xs text-gray-500 mt-2">Deactivating will stop your restaurant from receiving new orders</p>
                    @else
                        <button type="button" onclick="toggleRestaurantStatus('active')"
                                class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg font-medium transition text-sm flex items-center space-x-2">
                            <i class='bx bx-check'></i>
                            <span>Activate Restaurant</span>
                        </button>
                        <p class="text-xs text-gray-500 mt-2">Activating will make your restaurant available for orders</p>
                    @endif
                </div>
            </div>

            <!-- Restaurant Statistics -->
            <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class='bx bx-stats mr-2'></i>
                    Restaurant Statistics
                </h3>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="text-center p-4 bg-white rounded-lg border border-gray-200">
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['total_orders'] ?? 0 }}</p>
                        <p class="text-sm text-gray-600">Total Orders</p>
                    </div>
                    <div class="text-center p-4 bg-white rounded-lg border border-gray-200">
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['avg_rating'] ?? '4.7' }}</p>
                        <p class="text-sm text-gray-600">Avg Rating</p>
                    </div>
                    <div class="text-center p-4 bg-white rounded-lg border border-gray-200">
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['success_rate'] ?? '89' }}%</p>
                        <p class="text-sm text-gray-600">Success Rate</p>
                    </div>
                    <div class="text-center p-4 bg-white rounded-lg border border-gray-200">
                        <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($stats['total_revenue'] ?? 0, 0, ',', '.') }}</p>
                        <p class="text-sm text-gray-600">Total Revenue</p>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-between pt-6 border-t border-gray-100">
                <div>
                    <p class="text-sm text-gray-600">Last updated: {{ $restaurant->updated_at->format('M j, Y H:i') }}</p>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('owner.dashboard') }}" class="px-6 py-3 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition font-medium">
                        Cancel
                    </a>
                    <button type="submit" class="bg-primary-500 hover:bg-primary-600 text-white px-6 py-3 rounded-xl font-medium transition flex items-center space-x-2">
                        <i class='bx bx-save'></i>
                        <span>Save Changes</span>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Danger Zone -->
    <div class="mt-6 bg-red-50 border border-red-200 rounded-2xl p-6">
        <h3 class="font-semibold text-red-900 mb-3 flex items-center">
            <i class='bx bx-error-alt mr-2'></i>
            Danger Zone
        </h3>
        <p class="text-sm text-red-700 mb-4">
            These actions are permanent and cannot be undone. Please proceed with caution.
        </p>

        <div class="space-y-3">
            <!-- Contact Support -->
            <div class="flex items-center justify-between p-3 bg-white rounded-lg border border-red-200">
                <div>
                    <p class="font-medium text-red-900">Contact Support</p>
                    <p class="text-sm text-red-700">Need help? Contact our support team</p>
                </div>
                <button type="button"
                        class="px-4 py-2 border border-red-500 text-red-500 hover:bg-red-50 rounded-lg font-medium transition text-sm">
                    Contact
                </button>
            </div>
        </div>
    </div>
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
        let originalData = {
            name: document.getElementById('name').value,
            description: document.getElementById('description').value,
            address: document.getElementById('address').value,
            phone: document.getElementById('phone').value,
            email: document.getElementById('email').value
        };

        form.addEventListener('submit', function(e) {
            const descriptionLength = description.value.length;
            if (descriptionLength > 500) {
                e.preventDefault();
                alert('Description cannot exceed 500 characters.');
                description.focus();
                return;
            }

            const currentData = {
                name: document.getElementById('name').value,
                description: document.getElementById('description').value,
                address: document.getElementById('address').value,
                phone: document.getElementById('phone').value,
                email: document.getElementById('email').value
            };

            const hasChanges =
                currentData.name !== originalData.name ||
                currentData.description !== originalData.description ||
                currentData.address !== originalData.address ||
                currentData.phone !== originalData.phone ||
                currentData.email !== originalData.email ||
                document.getElementById('logo').files.length > 0 ||
                document.getElementById('cover_image').files.length > 0;

            if (!hasChanges) {
                e.preventDefault();
                alert('No changes detected.');
            }
        });

        // Initialize drag and drop
        setupDragAndDrop('logoUploadArea', 'logo', 'logoPreview', 'logoPreviewImage');
        setupDragAndDrop('coverUploadArea', 'cover_image', 'coverPreview', 'coverPreviewImage');
    });

    // Logo preview functionality
    function previewLogo(event) {
        const input = event.target;
        const preview = document.getElementById('logoPreview');
        const previewImage = document.getElementById('logoPreviewImage');
        const uploadArea = document.getElementById('logoUploadArea');
        const currentLogo = document.getElementById('currentLogo');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                previewImage.src = e.target.result;
                preview.classList.remove('hidden');
                uploadArea.classList.add('hidden');
                if (currentLogo) currentLogo.classList.add('hidden');
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
        const currentCover = document.getElementById('currentCover');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                previewImage.src = e.target.result;
                preview.classList.remove('hidden');
                uploadArea.classList.add('hidden');
                if (currentCover) currentCover.classList.add('hidden');
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    // Remove image functionality
    function removeImage(type) {
        if (confirm('Are you sure you want to remove this image?')) {
            fetch(`/owner/restaurants/remove-image/${type}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (type === 'logo') {
                        document.getElementById('currentLogo').remove();
                        document.getElementById('logoUploadArea').classList.remove('hidden');
                    } else if (type === 'cover') {
                        document.getElementById('currentCover').remove();
                        document.getElementById('coverUploadArea').classList.remove('hidden');
                    }
                    alert(data.message);
                } else {
                    alert('Failed to remove image: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to remove image');
            });
        }
    }

    // Toggle restaurant status
    function toggleRestaurantStatus(newStatus) {
        const action = newStatus === 'active' ? 'activate' : 'deactivate';
        const message = newStatus === 'active'
            ? 'Are you sure you want to activate your restaurant? This will make it available for orders.'
            : 'Are you sure you want to deactivate your restaurant? This will stop it from receiving new orders.';

        if (confirm(message)) {
            fetch('{{ route("owner.restaurants.toggle-status") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    status: newStatus
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    window.location.reload();
                } else {
                    alert('Failed to update status: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to update status');
            });
        }
    }

    // Drag and drop functionality
    function setupDragAndDrop(uploadAreaId, inputId, previewId, previewImageId) {
        const uploadArea = document.getElementById(uploadAreaId);
        const input = document.getElementById(inputId);
        const preview = document.getElementById(previewId);
        const previewImage = document.getElementById(previewImageId);

        if (!uploadArea) return;

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
</script>
@endsection
