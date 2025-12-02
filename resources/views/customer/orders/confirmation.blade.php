<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    @include('customer.partials.head')

    <style>
        .confirmation-animation {
            animation: bounce 2s infinite;
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {transform: translateY(0);}
            40% {transform: translateY(-10px);}
            60% {transform: translateY(-5px);}
        }

        .timeline-item.active .timeline-icon {
            background: #22c55e;
            color: white;
        }

        .timeline-item.completed .timeline-icon {
            background: #22c55e;
            color: white;
        }

        .timeline-item:not(.active):not(.completed) .timeline-icon {
            background: #e5e7eb;
            color: #6b7280;
        }
    </style>
</head>
<body class="font-poppins bg-gray-50 min-h-screen">
    @include('customer.partials.navigation')

    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Success Header -->
        <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 text-center mb-8">
            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6 confirmation-animation">
                <i class='bx bx-check text-green-600 text-3xl'></i>
            </div>

            <h1 class="text-3xl font-bold text-gray-900 mb-4">Order Placed Successfully!</h1>
            <p class="text-gray-600 mb-2">Thank you for your order. We've sent a confirmation to your email.</p>
            <p class="text-gray-600 mb-6">
                Order Number: <strong class="text-primary-600">{{ $order->order_number }}</strong>
            </p>

            <!-- Order Timeline -->
            <div class="max-w-2xl mx-auto mb-8">
                <div class="flex items-center justify-between relative">
                    @foreach($order->timeline as $status => $timelineItem)
                    <div class="flex flex-col items-center flex-1">
                        <div class="flex flex-col items-center">
                            <div class="timeline-icon w-12 h-12 rounded-full flex items-center justify-center mb-2 transition-all duration-300
                                {{ $timelineItem['active'] ? 'active' : '' }}
                                {{ $timelineItem['completed'] ? 'completed' : '' }}">
                                <i class='bx {{ $timelineItem['icon'] }} text-xl'></i>
                            </div>
                            <div class="text-center">
                                <p class="font-semibold text-gray-900 text-sm">{{ $timelineItem['status'] }}</p>
                                <p class="text-gray-500 text-xs">{{ $timelineItem['description'] }}</p>
                            </div>
                        </div>
                    </div>
                    @if(!$loop->last)
                    <div class="flex-1 h-1 bg-gray-200 mx-2">
                        <div class="h-full bg-primary-500 transition-all duration-500
                            {{ $timelineItem['completed'] ? 'w-full' : 'w-0' }}"></div>
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('customer.orders.show', $order) }}"
                   class="bg-primary-500 hover:bg-primary-600 text-white px-6 py-3 rounded-xl font-semibold transition flex items-center justify-center space-x-2">
                    <i class='bx bx-map'></i>
                    <span>Track Your Order</span>
                </a>
                <a href="{{ route('customer.orders.index') }}"
                   class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-xl font-semibold transition flex items-center justify-center space-x-2">
                    <i class='bx bx-history'></i>
                    <span>View Order History</span>
                </a>
                <a href="{{ route('customer.restaurants') }}"
                   class="bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-xl font-semibold transition flex items-center justify-center space-x-2">
                    <i class='bx bx-food-menu'></i>
                    <span>Order Again</span>
                </a>
            </div>
        </div>

        <!-- Order Details -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Order Summary -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Order Summary</h2>

                <!-- Restaurant Info -->
                <div class="flex items-center space-x-3 mb-4 p-3 bg-gray-50 rounded-lg">
                    @if($order->restaurant->logo)
                    <img src="{{ asset('storage/' . $order->restaurant->logo) }}"
                         alt="{{ $order->restaurant->name }}"
                         class="w-10 h-10 rounded-lg object-cover">
                    @else
                    <i class='bx bx-restaurant text-primary-600 text-2xl'></i>
                    @endif
                    <div>
                        <p class="font-semibold text-gray-900">{{ $order->restaurant->name }}</p>
                        <p class="text-gray-600 text-sm">{{ $order->restaurant->address }}</p>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="space-y-3 mb-4">
                    @foreach($order->orderItems as $orderItem)
                    <div class="flex justify-between items-start py-2 border-b border-gray-100">
                        <div class="flex items-start space-x-3">
                            <span class="text-gray-600 bg-gray-100 rounded-full w-6 h-6 flex items-center justify-center text-xs font-medium mt-1">
                                {{ $orderItem->quantity }}
                            </span>
                            <div>
                                <p class="font-medium text-gray-900">{{ $orderItem->menuItem->name }}</p>
                                @if($orderItem->customizations && !empty($orderItem->customizations))
                                <p class="text-sm text-gray-500 mt-1">
                                    {{ $orderItem->customizations_text }}
                                </p>
                                @endif
                                <p class="text-sm text-gray-600">{{ $orderItem->formatted_unit_price }}</p>
                            </div>
                        </div>
                        <p class="font-semibold text-gray-900">{{ $orderItem->formatted_total_price }}</p>
                    </div>
                    @endforeach
                </div>

                <!-- Price Breakdown -->
                <div class="space-y-2 border-t border-gray-200 pt-4">
                    <div class="flex justify-between text-gray-600">
                        <span>Subtotal</span>
                        <span>{{ 'Rp ' . number_format($order->subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Delivery Fee</span>
                        <span>{{ $order->formatted_delivery_fee }}</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Tax (10%)</span>
                        <span>{{ $order->formatted_tax_amount }}</span>
                    </div>
                    <div class="flex justify-between font-bold text-lg text-gray-900 border-t border-gray-200 pt-2">
                        <span>Total</span>
                        <span>{{ $order->formatted_total }}</span>
                    </div>
                </div>
            </div>

            <!-- Delivery & Payment Info -->
            <div class="space-y-6">
                <!-- Delivery Information -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Delivery Information</h2>
                    <div class="space-y-3">
                        <div class="flex items-center space-x-3">
                            <i class='bx bx-user text-gray-400 text-xl'></i>
                            <div>
                                <p class="text-sm text-gray-500">Customer Name</p>
                                <p class="font-medium text-gray-900">{{ $order->customer_name }}</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <i class='bx bx-phone text-gray-400 text-xl'></i>
                            <div>
                                <p class="text-sm text-gray-500">Phone Number</p>
                                <p class="font-medium text-gray-900">{{ $order->customer_phone }}</p>
                            </div>
                        </div>
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

                <!-- Payment Information -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Payment Information</h2>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <i class='bx {{ $order->payment_method_icon }} text-gray-400 text-xl'></i>
                                <div>
                                    <p class="text-sm text-gray-500">Payment Method</p>
                                    <p class="font-medium text-gray-900">{{ $order->payment_method_text }}</p>
                                </div>
                            </div>
                            <span class="px-3 py-1 rounded-full text-xs font-medium {{ $order->payment_status_badge }}">
                                {{ $order->payment_status_text }}
                            </span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <i class='bx bx-calendar text-gray-400 text-xl'></i>
                            <div>
                                <p class="text-sm text-gray-500">Order Date & Time</p>
                                <p class="font-medium text-gray-900">{{ $order->ordered_at->format('M j, Y \a\t g:i A') }}</p>
                            </div>
                        </div>
                        @if($order->payment_method === 'cash')
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mt-3">
                            <div class="flex items-center">
                                <i class='bx bx-info-circle text-yellow-600 mr-2'></i>
                                <p class="text-yellow-800 text-sm">
                                    Please prepare exact change for the delivery driver.
                                </p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Support Information -->
        <div class="bg-blue-50 border border-blue-200 rounded-2xl p-6 mt-8 text-center">
            <h3 class="text-lg font-semibold text-blue-900 mb-2">Need Help with Your Order?</h3>
            <p class="text-blue-700 mb-4">Our customer support team is here to assist you</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="tel:+62123456789"
                   class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg font-medium transition flex items-center justify-center space-x-2">
                    <i class='bx bx-phone'></i>
                    <span>Call Support: +62 123 456 789</span>
                </a>
                <a href="https://wa.me/628123456789" target="_blank"
                   class="bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded-lg font-medium transition flex items-center justify-center space-x-2">
                    <i class='bx bxl-whatsapp'></i>
                    <span>Chat on WhatsApp</span>
                </a>
            </div>
        </div>
    </main>

    @include('customer.partials.footer')
</body>
</html>
