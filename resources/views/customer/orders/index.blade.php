<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>

    @include('customer.partials.head')

    <style>
        .order-card {
            transition: all 0.3s ease;
        }

        .order-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .stats-card {
            transition: all 0.3s ease;
        }

        .stats-card:hover {
            transform: translateY(-2px);
        }

        .filter-btn.active {
            background: #22c55e;
            color: white;
        }
    </style>
</head>
<body class="font-poppins bg-gray-50 min-h-screen">
    <!-- Navigation -->
    @include('customer.partials.navigation')

    <!-- Header -->
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">My Orders</h1>
                    <p class="text-gray-600 mt-2">Track and manage your food orders</p>
                </div>

                <div class="text-right">
                    <p class="text-sm text-gray-500">Total Orders</p>
                    <p class="text-2xl font-bold text-primary-600">{{ $orderStats['total'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Order Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="stats-card bg-white rounded-2xl p-6 shadow-sm border border-gray-100 text-center">
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i class='bx bx-package text-blue-600 text-xl'></i>
                </div>
                <p class="text-2xl font-bold text-gray-900">{{ $orderStats['total'] }}</p>
                <p class="text-gray-600">Total Orders</p>
            </div>

            <div class="stats-card bg-white rounded-2xl p-6 shadow-sm border border-gray-100 text-center">
                <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i class='bx bx-time text-yellow-600 text-xl'></i>
                </div>
                <p class="text-2xl font-bold text-gray-900">{{ $orderStats['pending'] }}</p>
                <p class="text-gray-600">Active Orders</p>
            </div>

            <div class="stats-card bg-white rounded-2xl p-6 shadow-sm border border-gray-100 text-center">
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i class='bx bx-check-circle text-green-600 text-xl'></i>
                </div>
                <p class="text-2xl font-bold text-gray-900">{{ $orderStats['completed'] }}</p>
                <p class="text-gray-600">Completed</p>
            </div>

            <div class="stats-card bg-white rounded-2xl p-6 shadow-sm border border-gray-100 text-center">
                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i class='bx bx-x-circle text-red-600 text-xl'></i>
                </div>
                <p class="text-2xl font-bold text-gray-900">{{ $orderStats['cancelled'] }}</p>
                <p class="text-gray-600">Cancelled</p>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 mb-8">
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('customer.orders.index') }}"
                   class="filter-btn px-4 py-2 rounded-xl font-medium transition {{ $filter === 'all' ? 'active bg-primary-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    All Orders
                </a>
                <a href="{{ route('customer.orders.index', ['filter' => 'pending']) }}"
                   class="filter-btn px-4 py-2 rounded-xl font-medium transition {{ $filter === 'pending' ? 'active bg-primary-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    Active
                </a>
                <a href="{{ route('customer.orders.index', ['filter' => 'completed']) }}"
                   class="filter-btn px-4 py-2 rounded-xl font-medium transition {{ $filter === 'completed' ? 'active bg-primary-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    Completed
                </a>
                <a href="{{ route('customer.orders.index', ['filter' => 'cancelled']) }}"
                   class="filter-btn px-4 py-2 rounded-xl font-medium transition {{ $filter === 'cancelled' ? 'active bg-primary-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    Cancelled
                </a>
            </div>
        </div>

        <!-- Orders List -->
        <div class="space-y-6">
            @forelse($orders as $order)
            <div class="order-card bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                    <!-- Order Info -->
                    <div class="flex-1">
                        <div class="flex items-center space-x-4 mb-3">
                            <div class="flex items-center space-x-2">
                                <span class="px-3 py-1 rounded-full text-xs font-medium {{ $order->status_badge }}">
                                    {{ $order->status_text }}
                                </span>
                                <span class="text-sm text-gray-500">#{{ $order->order_number }}</span>
                            </div>
                            <span class="text-sm text-gray-500">{{ $order->created_at->format('M j, Y \a\t g:i A') }}</span>
                        </div>

                        <div class="flex items-center space-x-3 mb-3">
                            @if($order->restaurant->logo)
                            <img src="{{ asset('storage/' . $order->restaurant->logo) }}"
                                 alt="{{ $order->restaurant->name }}"
                                 class="w-10 h-10 rounded-lg object-cover">
                            @else
                            <i class='bx bx-restaurant text-primary-600 text-2xl'></i>
                            @endif
                            <div>
                                <h3 class="font-semibold text-gray-900">{{ $order->restaurant->name }}</h3>
                                <p class="text-gray-600 text-sm">{{ $order->total_items }} items • {{ $order->formatted_total }}</p>
                            </div>
                        </div>

                        <!-- Order Items Preview -->
                        <div class="text-sm text-gray-600">
                            @foreach($order->orderItems->take(2) as $item)
                            <span>{{ $item->quantity }}x {{ $item->menuItem->name }}@if(!$loop->last), @endif</span>
                            @endforeach
                            @if($order->orderItems->count() > 2)
                            <span>and {{ $order->orderItems->count() - 2 }} more</span>
                            @endif
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex flex-col sm:flex-row gap-3">
                        <a href="{{ route('customer.orders.show', $order) }}"
                            class="bg-primary-500 hover:bg-primary-600 text-white px-4 py-2 rounded-xl font-medium transition flex items-center justify-center space-x-2">
                            <i class='bx bx-show'></i>
                            <span>Track Order</span>
                        </a>

                        <a href="{{ route('customer.orders.show', $order) }}"
                           class="bg-primary-500 hover:bg-primary-600 text-white px-4 py-2 rounded-xl font-medium transition flex items-center justify-center space-x-2">
                            <i class='bx bx-show'></i>
                            <span>View Details</span>
                        </a>

                        @if($order->status === 'completed' && $order->can_be_reviewed)
                        <button onclick="openReviewModal({{ $order->id }})"
                                class="border border-gray-300 text-gray-700 px-4 py-2 rounded-xl font-medium transition hover:bg-gray-50 flex items-center justify-center space-x-2">
                            <i class='bx bx-star'></i>
                            <span>Review</span>
                        </button>
                        @endif

                        @if($order->status === 'completed')
                        <button onclick="reorder({{ $order->id }})"
                                class="border border-green-300 text-green-700 px-4 py-2 rounded-xl font-medium transition hover:bg-green-50 flex items-center justify-center space-x-2">
                            <i class='bx bx-recycle'></i>
                            <span>Reorder</span>
                        </button>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="bg-white rounded-2xl p-12 shadow-sm border border-gray-100 text-center">
                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class='bx bx-package text-gray-400 text-3xl'></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">No orders found</h3>
                <p class="text-gray-600 mb-6">You haven't placed any orders yet.</p>
                <a href="{{ route('customer.restaurants') }}"
                   class="bg-primary-500 hover:bg-primary-600 text-white px-6 py-3 rounded-xl font-semibold transition inline-flex items-center space-x-2">
                    <i class='bx bx-food-menu'></i>
                    <span>Browse Restaurants</span>
                </a>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($orders->hasPages())
        <div class="mt-8">
            {{ $orders->links() }}
        </div>
        @endif
    </main>

    <!-- Review Modal -->
    <div id="reviewModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-2xl p-6 m-4 max-w-md w-full">
            <h3 class="text-xl font-semibold text-gray-900 mb-4">Rate Your Order</h3>

            <form id="reviewForm">
                @csrf
                <input type="hidden" name="order_id" id="reviewOrderId">

                <!-- Rating -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Rating</label>
                    <div class="flex space-x-1" id="ratingStars">
                        @for($i = 1; $i <= 5; $i++)
                        <button type="button"
                                class="text-2xl rating-star"
                                data-rating="{{ $i }}"
                                onclick="setRating({{ $i }})">
                            <i class='bx bx-star text-gray-300'></i>
                        </button>
                        @endfor
                    </div>
                    <input type="hidden" name="rating" id="selectedRating" required>
                </div>

                <!-- Comment -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Comment (Optional)</label>
                    <textarea name="comment"
                              id="reviewComment"
                              rows="3"
                              class="w-full px-3 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                              placeholder="Share your experience..."></textarea>
                </div>

                <!-- Actions -->
                <div class="flex space-x-3">
                    <button type="button"
                            onclick="closeReviewModal()"
                            class="flex-1 bg-gray-500 hover:bg-gray-600 text-white py-3 rounded-xl font-medium transition">
                        Cancel
                    </button>
                    <button type="submit"
                            class="flex-1 bg-primary-500 hover:bg-primary-600 text-white py-3 rounded-xl font-medium transition">
                        Submit Review
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Footer -->
    @include('customer.partials.footer')

    <script>
        // Review Modal Functions
        let currentRating = 0;

        function openReviewModal(orderId) {
            document.getElementById('reviewOrderId').value = orderId;
            document.getElementById('reviewModal').classList.remove('hidden');
            resetRating();
        }

        function closeReviewModal() {
            document.getElementById('reviewModal').classList.add('hidden');
            resetRating();
        }

        function setRating(rating) {
            currentRating = rating;
            document.getElementById('selectedRating').value = rating;

            const stars = document.querySelectorAll('.rating-star');
            stars.forEach((star, index) => {
                const icon = star.querySelector('i');
                if (index < rating) {
                    icon.className = 'bx bxs-star text-yellow-400 text-2xl';
                } else {
                    icon.className = 'bx bx-star text-gray-300 text-2xl';
                }
            });
        }

        function resetRating() {
            currentRating = 0;
            document.getElementById('selectedRating').value = '';
            const stars = document.querySelectorAll('.rating-star');
            stars.forEach(star => {
                const icon = star.querySelector('i');
                icon.className = 'bx bx-star text-gray-300 text-2xl';
            });
        }

        // Review Form Submission
        document.getElementById('reviewForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const orderId = document.getElementById('reviewOrderId').value;
            const formData = new FormData(this);

            try {
                const response = await fetch(`/orders/${orderId}/review`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                const data = await response.json();

                if (data.success) {
                    alert('Thank you for your review!');
                    closeReviewModal();
                    location.reload();
                } else {
                    alert(data.message || 'Failed to submit review');
                }
            } catch (error) {
                console.error('Error submitting review:', error);
                alert('Error submitting review. Please try again.');
            }
        });

        // Reorder Function
        async function reorder(orderId) {
            if (!confirm('Add all items from this order to your cart?')) {
                return;
            }

            try {
                const response = await fetch(`/orders/${orderId}/reorder`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                if (data.success) {
                    alert('Items added to cart successfully!');
                    window.location.href = data.redirect_url;
                } else {
                    alert(data.message || 'Failed to reorder');
                }
            } catch (error) {
                console.error('Error reordering:', error);
                alert('Error reordering. Please try again.');
            }
        }
    </script>
</body>
</html>
