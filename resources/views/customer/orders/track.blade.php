<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>

    @include('customer.partials.head')

    <style>
        .tracking-timeline .step {
            transition: all 0.3s ease;
        }

        .tracking-timeline .step.completed {
            background: #dcfce7;
            border-color: #22c55e;
        }

        .tracking-timeline .step.active {
            background: #fef3c7;
            border-color: #f59e0b;
            transform: scale(1.05);
        }

        .driver-marker {
            animation: moveMarker 3s ease-in-out infinite;
        }

        @keyframes moveMarker {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }

        .pulse-dot {
            animation: pulseDot 2s infinite;
        }

        @keyframes pulseDot {
            0% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.2); opacity: 0.7; }
            100% { transform: scale(1); opacity: 1; }
        }

        .progress-bar {
            transition: width 0.5s ease-in-out;
        }

        .live-indicator {
            animation: pulseLive 1.5s infinite;
        }

        @keyframes pulseLive {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
    </style>
</head>
<body class="font-poppins bg-gray-50 min-h-screen" x-data="trackingPage()">
    <!-- Navigation -->
    @include('customer.partials.navigation')

    <!-- Tracking Header -->
    <div class="bg-white border-b border-gray-200 sticky top-0 z-30">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('customer.orders.index') }}"
                       class="text-gray-500 hover:text-gray-700 transition">
                        <i class='bx bx-arrow-back text-xl'></i>
                    </a>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Track Your Order</h1>
                        <p class="text-gray-600 flex items-center space-x-2">
                            <span>#{{ $order->order_number }}</span>
                            <span class="live-indicator flex items-center space-x-1 text-red-500 text-sm">
                                <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                                <span>LIVE</span>
                            </span>
                        </p>
                    </div>
                </div>

                <div class="text-right">
                    <p class="text-sm text-gray-500">Estimated Delivery</p>
                    <p class="font-semibold text-gray-900">{{ $estimatedDelivery->format('h:i A') }}</p>
                    <p class="text-xs text-gray-500">in about {{ $estimatedDelivery->diffForHumans(['parts' => 2, 'short' => true]) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Tracking Content -->
    <main class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Order Timeline & Tracking -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Current Status Card -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-semibold text-gray-900">Current Status</h2>
                        <span class="px-3 py-1 rounded-full text-sm font-medium {{ $order->status_badge }}">
                            {{ $order->status_text }}
                        </span>
                    </div>

                    <!-- Progress Bar -->
                    <div class="mb-6">
                        <div class="flex justify-between text-sm text-gray-600 mb-2">
                            <span>Order Placed</span>
                            <span>Delivered</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            @php
                                $progress = match($order->status) {
                                    'pending' => 10,
                                    'confirmed' => 25,
                                    'preparing' => 50,
                                    'ready' => 75,
                                    'on_the_way' => 90,
                                    'completed' => 100,
                                    default => 0
                                };
                            @endphp
                            <div class="progress-bar bg-primary-500 h-2 rounded-full transition-all duration-500"
                                 style="width: {{ $progress }}%"></div>
                        </div>
                    </div>

                    <!-- Status Message -->
                    <div class="bg-primary-50 border border-primary-200 rounded-xl p-4">
                        <div class="flex items-center space-x-3">
                            <i class='bx bx-time text-primary-600 text-xl'></i>
                            <div>
                                <p class="font-semibold text-primary-900">
                                    @switch($order->status)
                                        @case('pending')
                                            Waiting for restaurant confirmation
                                            @break
                                        @case('confirmed')
                                            Restaurant is preparing your order
                                            @break
                                        @case('preparing')
                                            Your food is being cooked
                                            @break
                                        @case('ready')
                                            Your order is ready for pickup
                                            @break
                                        @case('on_the_way')
                                            Driver is on the way to you
                                            @break
                                        @case('completed')
                                            Order delivered successfully!
                                            @break
                                        @default
                                            Tracking your order
                                    @endswitch
                                </p>
                                <p class="text-primary-700 text-sm mt-1">
                                    @switch($order->status)
                                        @case('pending')
                                            The restaurant will confirm your order shortly
                                            @break
                                        @case('confirmed')
                                            They'll start preparing your food soon
                                            @break
                                        @case('preparing')
                                            Estimated preparation time: 15-20 minutes
                                            @break
                                        @case('ready')
                                            Driver will pick up your order shortly
                                            @break
                                        @case('on_the_way')
                                            Your food is on its way!
                                            @break
                                        @case('completed')
                                            Enjoy your meal! 🎉
                                            @break
                                    @endswitch
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detailed Timeline -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <h2 class="text-xl font-semibold text-gray-900 mb-6">Order Journey</h2>

                    <!-- Timeline -->
                    <div class="tracking-timeline space-y-4">
                        @foreach($timeline as $key => $step)
                        <div class="step flex items-center space-x-4 p-4 border-2 rounded-xl transition-all duration-300"
                             :class="{
                                 'completed border-green-200 bg-green-50': {{ $step['status'] === 'completed' ? 'true' : 'false' }},
                                 'active border-orange-200 bg-orange-50': {{ $step['status'] === 'pending' && $loop->first ? 'true' : 'false' }},
                                 'border-gray-200': {{ $step['status'] === 'pending' && !$loop->first ? 'true' : 'false' }}
                             }">
                            <div class="flex-shrink-0 w-12 h-12 rounded-full flex items-center justify-center transition-all duration-300"
                                 :class="{
                                     'bg-green-500 text-white': {{ $step['status'] === 'completed' ? 'true' : 'false' }},
                                     'bg-orange-500 text-white': {{ $step['status'] === 'pending' && $loop->first ? 'true' : 'false' }},
                                     'bg-gray-300 text-gray-500': {{ $step['status'] === 'pending' && !$loop->first ? 'true' : 'false' }}
                                 }">
                                @switch($key)
                                    @case('order_placed')
                                    <i class='bx bx-cart text-xl'></i>
                                    @break
                                    @case('order_confirmed')
                                    <i class='bx bx-check-circle text-xl'></i>
                                    @break
                                    @case('food_preparing')
                                    <i class='bx bx-bowl-hot text-xl'></i>
                                    @break
                                    @case('food_ready')
                                    <i class='bx bx-package text-xl'></i>
                                    @break
                                    @case('on_the_way')
                                    <i class='bx bx-bike text-xl'></i>
                                    @break
                                    @case('delivered')
                                    <i class='bx bx-check-double text-xl'></i>
                                    @break
                                @endswitch
                            </div>

                            <div class="flex-1">
                                <p class="font-semibold text-gray-900">{{ $step['description'] }}</p>
                                @if($step['time'])
                                <p class="text-sm text-gray-500">{{ $step['time']->format('h:i A') }}</p>
                                @else
                                <p class="text-sm text-gray-400">Pending</p>
                                @endif
                            </div>

                            @if($step['status'] === 'completed')
                            <i class='bx bx-check text-green-500 text-2xl'></i>
                            @elseif($step['status'] === 'pending' && $loop->first)
                            <div class="pulse-dot w-3 h-3 bg-orange-500 rounded-full"></div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Live Tracking Map -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-semibold text-gray-900">Live Tracking</h2>
                        <button @click="refreshTracking()"
                                class="text-primary-600 hover:text-primary-700 transition flex items-center space-x-2">
                            <i class='bx bx-refresh'></i>
                            <span>Refresh</span>
                        </button>
                    </div>

                    <!-- Map Container -->
                    <div class="bg-gray-100 rounded-xl h-80 relative overflow-hidden mb-4">
                        <!-- Simplified Map Visualization -->
                        <div class="absolute inset-0 flex items-center justify-center">
                            <!-- Route Line -->
                            <div class="absolute top-1/2 left-1/4 right-1/4 h-1 bg-primary-200 transform -translate-y-1/2"></div>

                            <!-- Restaurant Location -->
                            <div class="absolute left-1/4 top-1/2 transform -translate-y-1/2">
                                <div class="text-center">
                                    <div class="w-16 h-16 bg-red-500 rounded-full flex items-center justify-center mx-auto mb-2 shadow-lg">
                                        <i class='bx bx-restaurant text-white text-xl'></i>
                                    </div>
                                    <div class="bg-white px-3 py-1 rounded-lg shadow-sm">
                                        <p class="text-xs font-medium text-gray-700">{{ $order->restaurant->name }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Driver Location -->
                            <div class="absolute left-1/2 top-1/2 transform -translate-y-1/2 driver-marker">
                                <div class="text-center">
                                    <div class="w-14 h-14 bg-primary-500 rounded-full flex items-center justify-center mx-auto mb-2 relative shadow-lg">
                                        <i class='bx bx-bike text-white text-lg'></i>
                                        <div class="absolute -top-1 -right-1 w-4 h-4 bg-green-400 rounded-full border-2 border-white pulse-dot"></div>
                                    </div>
                                    <div class="bg-white px-3 py-1 rounded-lg shadow-sm">
                                        <p class="text-xs font-medium text-gray-700">Driver</p>
                                        <p class="text-xs text-gray-500">5 min away</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Customer Location -->
                            <div class="absolute right-1/4 top-1/2 transform -translate-y-1/2">
                                <div class="text-center">
                                    <div class="w-16 h-16 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-2 shadow-lg">
                                        <i class='bx bx-home text-white text-xl'></i>
                                    </div>
                                    <div class="bg-white px-3 py-1 rounded-lg shadow-sm">
                                        <p class="text-xs font-medium text-gray-700">Your Location</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Driver Info -->
                    <div class="bg-primary-50 rounded-xl border border-primary-200 p-4">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class='bx bx-user text-primary-600 text-xl'></i>
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-gray-900">Budi Santoso</p>
                                <div class="flex items-center space-x-4 text-sm text-gray-600">
                                    <span class="flex items-center space-x-1">
                                        <i class='bx bx-star text-yellow-400'></i>
                                        <span>4.8</span>
                                    </span>
                                    <span class="flex items-center space-x-1">
                                        <i class='bx bx-bike'></i>
                                        <span>Honda Scooter</span>
                                    </span>
                                    <span class="flex items-center space-x-1">
                                        <i class='bx bx-car'></i>
                                        <span>B 1234 XYZ</span>
                                    </span>
                                </div>
                            </div>
                            <div class="flex space-x-2">
                                <button class="w-10 h-10 bg-primary-500 hover:bg-primary-600 text-white rounded-full flex items-center justify-center transition">
                                    <i class='bx bx-phone'></i>
                                </button>
                                <button class="w-10 h-10 bg-green-500 hover:bg-green-600 text-white rounded-full flex items-center justify-center transition">
                                    <i class='bx bxl-whatsapp'></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Summary & Actions -->
            <div class="lg:col-span-1">
                <div class="sticky top-32 space-y-6">
                    <!-- Order Summary -->
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">Order Summary</h3>

                        <!-- Restaurant Info -->
                        <div class="flex items-center space-x-3 mb-4 p-3 bg-gray-50 rounded-lg">
                            @if($order->restaurant->logo)
                            <img src="{{ asset('storage/' . $order->restaurant->logo) }}"
                                 alt="{{ $order->restaurant->name }}"
                                 class="w-10 h-10 rounded-lg object-cover">
                            @else
                            <i class='bx bx-restaurant text-primary-600 text-xl'></i>
                            @endif
                            <div class="flex-1">
                                <p class="font-semibold text-gray-900">{{ $order->restaurant->name }}</p>
                                <p class="text-gray-600 text-sm">{{ $order->restaurant->address }}</p>
                            </div>
                        </div>

                        <!-- Order Items -->
                        <div class="space-y-3 mb-4">
                            @foreach($order->orderItems as $item)
                            <div class="flex items-center justify-between text-sm">
                                <div class="flex items-center space-x-2">
                                    <span class="text-gray-500 bg-gray-100 rounded-full w-5 h-5 flex items-center justify-center text-xs">
                                        {{ $item->quantity }}
                                    </span>
                                    <span class="text-gray-700">{{ $item->menuItem->name }}</span>
                                </div>
                                <span class="font-medium text-gray-900">{{ $item->formatted_total_price }}</span>
                            </div>
                            @endforeach
                        </div>

                        <!-- Price Breakdown -->
                        <div class="border-t border-gray-200 pt-4 space-y-2">
                            <div class="flex justify-between text-sm text-gray-600">
                                <span>Subtotal</span>
                                <span>{{ $order->formatted_total }}</span>
                            </div>
                            <div class="flex justify-between text-sm text-gray-600">
                                <span>Delivery Fee</span>
                                <span>{{ $order->formatted_delivery_fee }}</span>
                            </div>
                            <div class="flex justify-between text-sm text-gray-600">
                                <span>Tax (10%)</span>
                                <span>{{ $order->formatted_tax_amount }}</span>
                            </div>
                            <div class="flex justify-between font-semibold text-gray-900 border-t border-gray-200 pt-2">
                                <span>Total</span>
                                <span>{{ $order->formatted_total }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Delivery Information -->
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">Delivery Info</h3>

                        <div class="space-y-3">
                            <div class="flex items-start space-x-3">
                                <i class='bx bx-map text-gray-400 text-xl mt-1'></i>
                                <div>
                                    <p class="text-sm text-gray-500">Delivery Address</p>
                                    <p class="font-medium text-gray-900">{{ $order->customer_address }}</p>
                                </div>
                            </div>

                            <div class="flex items-center space-x-3">
                                <i class='bx bx-time text-gray-400 text-xl'></i>
                                <div>
                                    <p class="text-sm text-gray-500">Delivery Time</p>
                                    <p class="font-medium text-gray-900">{{ $order->delivery_time_text }}</p>
                                </div>
                            </div>

                            @if($order->notes)
                            <div class="flex items-start space-x-3">
                                <i class='bx bx-note text-gray-400 text-xl mt-1'></i>
                                <div>
                                    <p class="text-sm text-gray-500">Delivery Notes</p>
                                    <p class="font-medium text-gray-900">{{ $order->notes }}</p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">Quick Actions</h3>

                        <div class="space-y-3">
                            @if($order->can_be_cancelled)
                            <button @click="cancelOrder({{ $order->id }})"
                                    class="w-full text-red-600 border border-red-300 py-3 rounded-xl font-medium transition hover:bg-red-50 flex items-center justify-center space-x-2">
                                <i class='bx bx-x-circle'></i>
                                <span>Cancel Order</span>
                            </button>
                            @endif

                            <a href="tel:{{ $order->restaurant->phone }}"
                               class="w-full border border-gray-300 text-gray-700 py-3 rounded-xl font-medium transition hover:bg-gray-50 flex items-center justify-center space-x-2">
                                <i class='bx bx-phone'></i>
                                <span>Call Restaurant</span>
                            </a>

                            <a href="{{ route('customer.orders.index') }}"
                               class="w-full border border-gray-300 text-gray-700 py-3 rounded-xl font-medium transition hover:bg-gray-50 flex items-center justify-center space-x-2">
                                <i class='bx bx-history'></i>
                                <span>Order History</span>
                            </a>

                            <button onclick="reorder({{ $order->id }})"
                                    class="w-full border border-green-300 text-green-700 py-3 rounded-xl font-medium transition hover:bg-green-50 flex items-center justify-center space-x-2">
                                <i class='bx bx-recycle'></i>
                                <span>Reorder Similar</span>
                            </button>
                        </div>
                    </div>

                    <!-- Support -->
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">Need Help?</h3>

                        <div class="space-y-3">
                            <a href="tel:+62123456789"
                               class="flex items-center space-x-3 p-3 rounded-xl hover:bg-gray-50 transition">
                                <i class='bx bx-support text-primary-600 text-xl'></i>
                                <div>
                                    <p class="font-medium text-gray-900">24/7 Support</p>
                                    <p class="text-gray-600 text-sm">+62 123 456 789</p>
                                </div>
                            </a>

                            <a href="https://wa.me/628123456789" target="_blank"
                               class="flex items-center space-x-3 p-3 rounded-xl hover:bg-gray-50 transition">
                                <i class='bx bxl-whatsapp text-green-600 text-xl'></i>
                                <div>
                                    <p class="font-medium text-gray-900">WhatsApp</p>
                                    <p class="text-gray-600 text-sm">Fast response</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    @include('customer.partials.footer')

    <script>
        function trackingPage() {
            return {
                autoRefresh: true,
                refreshInterval: null,
                lastUpdate: '{{ now()->format('h:i A') }}',

                init() {
                    console.log('Tracking initialized for order #{{ $order->order_number }}');
                    this.startAutoRefresh();
                },

                startAutoRefresh() {
                    if (this.autoRefresh) {
                        this.refreshInterval = setInterval(() => {
                            this.refreshTracking();
                        }, 10000); // Refresh every 10 seconds
                    }
                },

                stopAutoRefresh() {
                    if (this.refreshInterval) {
                        clearInterval(this.refreshInterval);
                        this.refreshInterval = null;
                    }
                },

                async refreshTracking() {
                    try {
                        console.log('Refreshing tracking data...');
                        const response = await fetch('{{ route("customer.orders.track", $order) }}');
                        const data = await response.json();

                        if (data.success) {
                            this.updateTrackingUI(data.order);
                            this.lastUpdate = new Date().toLocaleTimeString('en-US', {
                                hour: 'numeric',
                                minute: '2-digit',
                                hour12: true
                            });
                        }
                    } catch (error) {
                        console.error('Error refreshing tracking:', error);
                    }
                },

                updateTrackingUI(orderData) {
                    // Update status badge
                    const statusBadge = document.querySelector('[x-text="orderStatus"]');
                    if (statusBadge) {
                        statusBadge.textContent = orderData.status;
                        statusBadge.className = `px-3 py-1 rounded-full text-sm font-medium ${orderData.status_badge}`;
                    }

                    // Update progress bar
                    const progress = this.calculateProgress(orderData.status);
                    const progressBar = document.querySelector('.progress-bar');
                    if (progressBar) {
                        progressBar.style.width = `${progress}%`;
                    }

                    // Update timeline
                    this.updateTimeline(orderData.timeline);

                    console.log('Tracking UI updated:', orderData.status);
                },

                calculateProgress(status) {
                    const progressMap = {
                        'pending': 10,
                        'confirmed': 25,
                        'preparing': 50,
                        'ready': 75,
                        'on_the_way': 90,
                        'completed': 100
                    };
                    return progressMap[status] || 0;
                },

                updateTimeline(timeline) {
                    // This would update the timeline steps based on new data
                    // For now, we'll just log the update
                    console.log('Timeline updated:', timeline);
                },

                async cancelOrder(orderId) {
                    if (!confirm('Are you sure you want to cancel this order? This action cannot be undone.')) {
                        return;
                    }

                    const reason = prompt('Please tell us why you\'re cancelling:');
                    if (!reason) {
                        alert('Cancellation reason is required.');
                        return;
                    }

                    try {
                        const response = await fetch(`/orders/${orderId}/cancel`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                reason: reason
                            })
                        });

                        const data = await response.json();

                        if (data.success) {
                            alert('Order cancelled successfully');
                            this.stopAutoRefresh();
                            window.location.reload();
                        } else {
                            alert(data.message || 'Failed to cancel order');
                        }
                    } catch (error) {
                        console.error('Error cancelling order:', error);
                        alert('Error cancelling order. Please try again.');
                    }
                }
            }
        }

        // Reorder function
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

        // Refresh tracking manually
        function refreshTracking() {
            const trackingComponent = document.querySelector('[x-data="trackingPage()"]');
            if (trackingComponent && trackingComponent.__x) {
                trackingComponent.__x.$data.refreshTracking();
            }
        }

        // Auto-refresh when page becomes visible
        document.addEventListener('visibilitychange', function() {
            const trackingComponent = document.querySelector('[x-data="trackingPage()"]');
            if (!trackingComponent || !trackingComponent.__x) return;

            if (document.hidden) {
                trackingComponent.__x.$data.stopAutoRefresh();
            } else {
                trackingComponent.__x.$data.startAutoRefresh();
            }
        });
    </script>
</body>
</html>
