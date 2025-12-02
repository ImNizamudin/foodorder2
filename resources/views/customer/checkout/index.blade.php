<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} - FoodOrder</title>

    @include('customer.partials.head')

    <style>
        .checkout-step {
            transition: all 0.3s ease;
            border: 2px solid #e5e7eb;
        }

        .checkout-step.active {
            border-color: #22c55e;
            background: #f0fdf4;
        }

        .checkout-step.completed {
            border-color: #22c55e;
            background: #dcfce7;
        }

        .payment-method {
            transition: all 0.3s ease;
            border: 2px solid transparent;
            cursor: pointer;
        }

        .payment-method:hover {
            border-color: #d1d5db;
        }

        .payment-method.selected {
            border-color: #22c55e;
            background: #f0fdf4;
        }

        .address-card {
            transition: all 0.3s ease;
            border: 2px solid transparent;
            cursor: pointer;
        }

        .address-card:hover {
            border-color: #d1d5db;
        }

        .address-card.selected {
            border-color: #22c55e;
            background: #f0fdf4;
        }

        .step-content {
            animation: slideIn 0.3s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .loading-overlay {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(4px);
        }

        .form-input:focus {
            border-color: #22c55e;
            box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.1);
        }
    </style>
</head>
<body class="font-poppins bg-gray-50 min-h-screen" x-data="checkoutPage()">
    <!-- Navigation -->
    @include('customer.partials.navigation')

    <!-- Checkout Progress -->
    <div class="bg-white border-b border-gray-200 sticky top-0 z-30">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="py-6">
                <div class="flex items-center justify-center space-x-4 md:space-x-8">
                    <!-- Step 1: Order Review -->
                    <div class="checkout-step flex items-center space-x-3 px-4 py-3 rounded-lg"
                         :class="{
                             'active': currentStep === 1,
                             'completed': currentStep > 1
                         }">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-white text-sm font-semibold"
                             :class="currentStep >= 1 ? 'bg-primary-500' : 'bg-gray-300'">
                            <span x-show="currentStep <= 1">1</span>
                            <i class='bx bx-check' x-show="currentStep > 1"></i>
                        </div>
                        <span class="font-medium hidden sm:block">Order Review</span>
                    </div>

                    <!-- Step 2: Delivery -->
                    <div class="checkout-step flex items-center space-x-3 px-4 py-3 rounded-lg"
                         :class="{
                             'active': currentStep === 2,
                             'completed': currentStep > 2
                         }">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-white text-sm font-semibold"
                             :class="currentStep >= 2 ? 'bg-primary-500' : 'bg-gray-300'">
                            <span x-show="currentStep <= 2">2</span>
                            <i class='bx bx-check' x-show="currentStep > 2"></i>
                        </div>
                        <span class="font-medium hidden sm:block">Delivery</span>
                    </div>

                    <!-- Step 3: Payment -->
                    <div class="checkout-step flex items-center space-x-3 px-4 py-3 rounded-lg"
                         :class="{
                             'active': currentStep === 3,
                             'completed': currentStep > 3
                         }">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-white text-sm font-semibold"
                             :class="currentStep >= 3 ? 'bg-primary-500' : 'bg-gray-300'">
                            <span x-show="currentStep <= 3">3</span>
                            <i class='bx bx-check' x-show="currentStep > 3"></i>
                        </div>
                        <span class="font-medium hidden sm:block">Payment</span>
                    </div>

                    <!-- Step 4: Confirmation -->
                    <div class="checkout-step flex items-center space-x-3 px-4 py-3 rounded-lg"
                         :class="{
                             'active': currentStep === 4,
                             'completed': currentStep > 4
                         }">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-white text-sm font-semibold"
                             :class="currentStep >= 4 ? 'bg-primary-500' : 'bg-gray-300'">
                            <span x-show="currentStep <= 4">4</span>
                            <i class='bx bx-check' x-show="currentStep > 4"></i>
                        </div>
                        <span class="font-medium hidden sm:block">Confirmation</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Checkout Content -->
    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <form id="checkoutForm" method="POST" action="{{ route('customer.checkout.place') }}">
            @csrf

            <!-- Step 1: Order Review -->
            <div x-show="currentStep === 1" class="step-content" x-transition>
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 mb-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Review Your Order</h2>

                    <!-- Restaurant Info -->
                    <div class="flex items-center space-x-4 mb-6 p-4 bg-gray-50 rounded-xl">
                        <div class="w-16 h-16 bg-primary-50 rounded-xl flex items-center justify-center flex-shrink-0">
                            @if($restaurant->logo)
                            <img src="{{ asset('storage/' . $restaurant->logo) }}"
                                alt="{{ $restaurant->name }}"
                                class="w-12 h-12 rounded-lg object-cover">
                            @else
                            <i class='bx bx-restaurant text-primary-600 text-2xl'></i>
                            @endif
                        </div>
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-900 text-lg">{{ $restaurant->name }}</h3>
                            <p class="text-gray-600 text-sm">{{ $restaurant->address }}</p>
                            <div class="flex items-center space-x-4 mt-2 text-sm text-gray-500">
                                <span class="flex items-center space-x-1">
                                    <i class='bx bx-time text-xs'></i>
                                    <span>{{ $restaurant->delivery_time }} min delivery</span>
                                </span>
                                <span class="flex items-center space-x-1">
                                    <i class='bx bx-dollar-circle text-xs'></i>
                                    <span>{{ 'Rp ' . number_format($deliveryFee, 0, ',', '.') }} delivery fee</span>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Order Items -->
                    <div class="space-y-4 mb-6">
                        <h3 class="font-semibold text-gray-900 mb-4">Order Items</h3>
                        @foreach($cartItems as $cartItem)
                        <div class="flex items-center justify-between py-3 border-b border-gray-100">
                            <div class="flex items-center space-x-3">
                                <span class="text-gray-600 bg-gray-100 rounded-full w-8 h-8 flex items-center justify-center text-sm font-medium">
                                    {{ $cartItem['quantity'] }}
                                </span>
                                <div>
                                    <p class="font-medium text-gray-900">{{ $cartItem['menu_item']->name }}</p>
                                    @if(!empty($cartItem['customizations']))
                                    <p class="text-sm text-gray-500 mt-1">
                                        @foreach($cartItem['customizations'] as $key => $value)
                                        {{ ucfirst($key) }}: {{ $value }}@if(!$loop->last), @endif
                                        @endforeach
                                    </p>
                                    @endif
                                </div>
                            </div>
                            <p class="font-semibold text-gray-900">{{ 'Rp ' . number_format($cartItem['total_price'], 0, ',', '.') }}</p>
                        </div>
                        @endforeach
                    </div>

                    <!-- Order Summary -->
                    <div class="border-t border-gray-200 pt-4">
                        <h3 class="font-semibold text-gray-900 mb-4">Order Summary</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between text-gray-600">
                                <span>Subtotal ({{ count($cartItems) }} items)</span>
                                <span>{{ 'Rp ' . number_format($subtotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>Delivery Fee</span>
                                <span>{{ 'Rp ' . number_format($deliveryFee, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>Tax (10%)</span>
                                <span>{{ 'Rp ' . number_format($taxAmount, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between font-bold text-lg text-gray-900 border-t border-gray-200 pt-3">
                                <span>Total</span>
                                <span>{{ 'Rp ' . number_format($total, 0, ',', '.') }}</span>
                            </div>

                            <!-- Minimum Order Notice -->
                            @if($subtotal < $minOrder)
                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mt-4">
                                <div class="flex items-center">
                                    <i class='bx bx-info-circle text-yellow-600 mr-2'></i>
                                    <p class="text-yellow-800 text-sm">
                                        Minimum order for this restaurant is <strong>Rp {{ number_format($minOrder, 0, ',', '.') }}</strong>.
                                        Add more items to continue.
                                    </p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="flex justify-between">
                    <a href="{{ route('customer.cart') }}"
                       class="bg-gray-500 hover:bg-gray-600 text-white px-8 py-3 rounded-xl font-semibold transition flex items-center space-x-2">
                        <i class='bx bx-arrow-back'></i>
                        <span>Back to Cart</span>
                    </a>
                    <button type="button"
                            @click="currentStep = 2"
                            class="bg-primary-500 hover:bg-primary-600 text-white px-8 py-3 rounded-xl font-semibold transition flex items-center space-x-2"
                            :disabled="{{ $subtotal < $minOrder ? 'true' : 'false' }}"
                            :class="{{ $subtotal < $minOrder ? '"bg-gray-400 cursor-not-allowed"' : '""' }}">
                        <span>Continue to Delivery</span>
                        <i class='bx bx-chevron-right'></i>
                    </button>
                </div>
            </div>

            <!-- Step 2: Delivery Information -->
            <div x-show="currentStep === 2" class="step-content" x-transition>
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 mb-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Delivery Information</h2>

                    <!-- Delivery Address Form -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Delivery Address</h3>

                        <!-- Quick Address Options -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            <div class="address-card p-4 border-2 rounded-xl"
                                 @click="selectAddress('home')"
                                 :class="selectedAddress === 'home' ? 'selected border-primary-500' : 'border-gray-200'">
                                <div class="flex items-center space-x-3">
                                    <i class='bx bx-home text-xl text-primary-600'></i>
                                    <div>
                                        <p class="font-semibold text-gray-900">Home</p>
                                        <p class="text-gray-600 text-sm">123 Main Street, Apt 4B</p>
                                        <p class="text-gray-600 text-sm">Jakarta, 12345</p>
                                    </div>
                                </div>
                            </div>

                            <div class="address-card p-4 border-2 rounded-xl"
                                 @click="selectAddress('work')"
                                 :class="selectedAddress === 'work' ? 'selected border-primary-500' : 'border-gray-200'">
                                <div class="flex items-center space-x-3">
                                    <i class='bx bx-briefcase text-xl text-primary-600'></i>
                                    <div>
                                        <p class="font-semibold text-gray-900">Work</p>
                                        <p class="text-gray-600 text-sm">456 Office Blvd, Floor 8</p>
                                        <p class="text-gray-600 text-sm">Jakarta, 12345</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Delivery Form -->
                        <div class="border-t border-gray-200 pt-6">
                            <h4 class="font-semibold text-gray-900 mb-4">Delivery Details</h4>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Full Name <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text"
                                           name="customer_name"
                                           x-model="deliveryInfo.name"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl form-input transition"
                                           placeholder="Enter your full name"
                                           required>
                                    <p class="text-red-500 text-sm mt-1" x-show="errors.name" x-text="errors.name"></p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Phone Number <span class="text-red-500">*</span>
                                    </label>
                                    <input type="tel"
                                           name="customer_phone"
                                           x-model="deliveryInfo.phone"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl form-input transition"
                                           placeholder="+62 812-3456-7890"
                                           required>
                                    <p class="text-red-500 text-sm mt-1" x-show="errors.phone" x-text="errors.phone"></p>
                                </div>

                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Delivery Address <span class="text-red-500">*</span>
                                    </label>
                                    <textarea name="customer_address"
                                              rows="3"
                                              x-model="deliveryInfo.address"
                                              class="w-full px-4 py-3 border border-gray-300 rounded-xl form-input transition"
                                              placeholder="Enter your complete delivery address (street, building, floor, etc.)"
                                              required></textarea>
                                    <p class="text-red-500 text-sm mt-1" x-show="errors.address" x-text="errors.address"></p>
                                </div>

                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Delivery Notes (Optional)</label>
                                    <textarea name="delivery_notes"
                                              rows="2"
                                              x-model="deliveryInfo.notes"
                                              class="w-full px-4 py-3 border border-gray-300 rounded-xl form-input transition"
                                              placeholder="e.g., Don't ring the bell, leave at front door, specific instructions..."></textarea>
                                    <p class="text-gray-500 text-sm mt-1">Max 500 characters</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Delivery Time -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Delivery Time</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="p-4 border-2 rounded-xl cursor-pointer transition"
                                 :class="deliveryInfo.time === 'asap' ? 'border-primary-500 bg-primary-50' : 'border-gray-200 hover:border-gray-300'"
                                 @click="deliveryInfo.time = 'asap'">
                                <div class="flex items-center space-x-3">
                                    <i class='bx bx-time text-xl'
                                       :class="deliveryInfo.time === 'asap' ? 'text-primary-600' : 'text-gray-600'"></i>
                                    <div>
                                        <p class="font-semibold text-gray-900">ASAP</p>
                                        <p class="text-gray-600 text-sm">Estimated 25-35 minutes</p>
                                    </div>
                                </div>
                            </div>

                            <div class="p-4 border-2 rounded-xl cursor-pointer transition"
                                 :class="deliveryInfo.time === 'schedule' ? 'border-primary-500 bg-primary-50' : 'border-gray-200 hover:border-gray-300'"
                                 @click="deliveryInfo.time = 'schedule'">
                                <div class="flex items-center space-x-3">
                                    <i class='bx bx-calendar text-xl'
                                       :class="deliveryInfo.time === 'schedule' ? 'text-primary-600' : 'text-gray-600'"></i>
                                    <div>
                                        <p class="font-semibold text-gray-900">Schedule</p>
                                        <p class="text-gray-600 text-sm">Choose specific time</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="delivery_time" x-model="deliveryInfo.time">
                    </div>
                </div>

                <div class="flex justify-between">
                    <button type="button" @click="currentStep = 1"
                            class="bg-gray-500 hover:bg-gray-600 text-white px-8 py-3 rounded-xl font-semibold transition flex items-center space-x-2">
                        <i class='bx bx-chevron-left'></i>
                        <span>Back to Order</span>
                    </button>
                    <button type="button" @click="validateDelivery()"
                            class="bg-primary-500 hover:bg-primary-600 text-white px-8 py-3 rounded-xl font-semibold transition flex items-center space-x-2">
                        <span>Continue to Payment</span>
                        <i class='bx bx-chevron-right'></i>
                    </button>
                </div>
            </div>

            <!-- Step 3: Payment Method -->
            <div x-show="currentStep === 3" class="step-content" x-transition>
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 mb-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Payment Method</h2>

                    <!-- Payment Options -->
                    <div class="space-y-4 mb-8">
                        <!-- Cash on Delivery -->
                        <div class="payment-method p-4 border-2 rounded-xl"
                             @click="selectPayment('cash')"
                             :class="selectedPayment === 'cash' ? 'selected border-primary-500' : 'border-gray-200'">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <i class='bx bx-money text-2xl text-green-600'></i>
                                    <div>
                                        <p class="font-semibold text-gray-900">Cash on Delivery</p>
                                        <p class="text-gray-600 text-sm">Pay when you receive your order</p>
                                    </div>
                                </div>
                                <div class="w-6 h-6 rounded-full border-2 flex items-center justify-center"
                                     :class="selectedPayment === 'cash' ? 'border-primary-500 bg-primary-500' : 'border-gray-300'">
                                    <i class='bx bx-check text-white text-xs'
                                       x-show="selectedPayment === 'cash'"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Credit/Debit Card -->
                        <div class="payment-method p-4 border-2 rounded-xl"
                             @click="selectPayment('card')"
                             :class="selectedPayment === 'card' ? 'selected border-primary-500' : 'border-gray-200'">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <i class='bx bx-credit-card text-2xl text-blue-600'></i>
                                    <div>
                                        <p class="font-semibold text-gray-900">Credit/Debit Card</p>
                                        <p class="text-gray-600 text-sm">Pay securely with your card</p>
                                    </div>
                                </div>
                                <div class="w-6 h-6 rounded-full border-2 flex items-center justify-center"
                                     :class="selectedPayment === 'card' ? 'border-primary-500 bg-primary-500' : 'border-gray-300'">
                                    <i class='bx bx-check text-white text-xs'
                                       x-show="selectedPayment === 'card'"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Digital Wallet -->
                        <div class="payment-method p-4 border-2 rounded-xl"
                             @click="selectPayment('digital_wallet')"
                             :class="selectedPayment === 'digital_wallet' ? 'selected border-primary-500' : 'border-gray-200'">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <i class='bx bx-wallet text-2xl text-purple-600'></i>
                                    <div>
                                        <p class="font-semibold text-gray-900">Digital Wallet</p>
                                        <p class="text-gray-600 text-sm">Gopay, OVO, DANA, etc.</p>
                                    </div>
                                </div>
                                <div class="w-6 h-6 rounded-full border-2 flex items-center justify-center"
                                     :class="selectedPayment === 'digital_wallet' ? 'border-primary-500 bg-primary-500' : 'border-gray-300'">
                                    <i class='bx bx-check text-white text-xs'
                                       x-show="selectedPayment === 'digital_wallet'"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="border-t border-gray-200 pt-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Order Summary</h3>
                        <div class="space-y-2">
                            <div class="flex justify-between text-gray-600">
                                <span>Items Total</span>
                                <span>{{ 'Rp ' . number_format($subtotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>Delivery</span>
                                <span>{{ 'Rp ' . number_format($deliveryFee, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>Tax (10%)</span>
                                <span>{{ 'Rp ' . number_format($taxAmount, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between font-bold text-lg text-gray-900 border-t border-gray-200 pt-2">
                                <span>Total</span>
                                <span>{{ 'Rp ' . number_format($total, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-between">
                    <button type="button" @click="currentStep = 2"
                            class="bg-gray-500 hover:bg-gray-600 text-white px-8 py-3 rounded-xl font-semibold transition flex items-center space-x-2">
                        <i class='bx bx-chevron-left'></i>
                        <span>Back to Delivery</span>
                    </button>
                    <button type="button" @click="placeOrder()"
                            class="bg-primary-500 hover:bg-primary-600 text-white px-8 py-3 rounded-xl font-semibold transition flex items-center space-x-2"
                            :disabled="placingOrder">
                        <i class='bx bx-loader-circle bx-spin' x-show="placingOrder"></i>
                        <span x-text="placingOrder ? 'Placing Order...' : 'Place Order'"></span>
                    </button>
                </div>
            </div>

            <!-- Hidden fields -->
            <input type="hidden" name="payment_method" x-model="selectedPayment">
            <input type="hidden" name="customer_name" x-model="deliveryInfo.name">
            <input type="hidden" name="customer_phone" x-model="deliveryInfo.phone">
            <input type="hidden" name="customer_address" x-model="deliveryInfo.address">
            <input type="hidden" name="delivery_notes" x-model="deliveryInfo.notes">
        </form>
    </main>

    <!-- Loading Overlay -->
    <div x-show="placingOrder" class="fixed inset-0 bg-white bg-opacity-80 flex items-center justify-center z-50 loading-overlay">
        <div class="text-center">
            <div class="w-16 h-16 bg-primary-500 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class='bx bx-loader-circle bx-spin text-white text-2xl'></i>
            </div>
            <p class="text-gray-700 font-semibold">Placing your order...</p>
            <p class="text-gray-500 text-sm">Please wait while we process your order</p>
        </div>
    </div>

    <!-- Footer -->
    @include('customer.partials.footer')

    <script>
        function checkoutPage() {
            return {
                currentStep: 1,
                selectedAddress: 'home',
                selectedPayment: 'cash',
                placingOrder: false,
                deliveryInfo: {
                    name: '{{ auth()->user()->name ?? "" }}',
                    phone: '{{ auth()->user()->phone ?? "" }}',
                    address: '',
                    notes: '',
                    time: 'asap'
                },
                errors: {
                    name: '',
                    phone: '',
                    address: ''
                },

                init() {
                    console.log('Checkout initialized - Step 1');
                    // Pre-fill user data if available
                    if (!this.deliveryInfo.name && '{{ auth()->user()->name ?? "" }}') {
                        this.deliveryInfo.name = '{{ auth()->user()->name ?? "" }}';
                    }
                    if (!this.deliveryInfo.phone && '{{ auth()->user()->phone ?? "" }}') {
                        this.deliveryInfo.phone = '{{ auth()->user()->phone ?? "" }}';
                    }

                    // Auto-select home address on init
                    this.selectAddress('home');
                },

                selectAddress(address) {
                    this.selectedAddress = address;
                    // In real app, you'd populate form with saved address data
                    if (address === 'home') {
                        this.deliveryInfo.address = '123 Main Street, Apt 4B, Jakarta, 12345';
                    } else if (address === 'work') {
                        this.deliveryInfo.address = '456 Office Blvd, Floor 8, Jakarta, 12345';
                    }

                    // Clear errors when address is selected
                    this.errors.address = '';
                },

                selectPayment(payment) {
                    this.selectedPayment = payment;
                },

                validateDelivery() {
                    console.log('Validating delivery information...');

                    // Reset errors
                    this.errors = { name: '', phone: '', address: '' };

                    let isValid = true;

                    // Validate name
                    if (!this.deliveryInfo.name.trim()) {
                        this.errors.name = 'Full name is required';
                        isValid = false;
                    } else if (this.deliveryInfo.name.trim().length < 2) {
                        this.errors.name = 'Name must be at least 2 characters';
                        isValid = false;
                    }

                    // Validate phone
                    if (!this.deliveryInfo.phone.trim()) {
                        this.errors.phone = 'Phone number is required';
                        isValid = false;
                    } else {
                        const phoneRegex = /^[+]?[\d\s\-()]{10,}$/;
                        if (!phoneRegex.test(this.deliveryInfo.phone.replace(/\s/g, ''))) {
                            this.errors.phone = 'Please enter a valid phone number';
                            isValid = false;
                        }
                    }

                    // Validate address
                    if (!this.deliveryInfo.address.trim()) {
                        this.errors.address = 'Delivery address is required';
                        isValid = false;
                    } else if (this.deliveryInfo.address.trim().length < 10) {
                        this.errors.address = 'Please enter a complete address';
                        isValid = false;
                    }

                    if (isValid) {
                        console.log('Delivery validation passed, moving to step 3');
                        this.currentStep = 3;
                        this.showNotification('Delivery information saved!', 'success');
                    } else {
                        console.log('Delivery validation failed:', this.errors);
                        this.showNotification('Please fix the errors below', 'error');
                    }
                },

                async placeOrder() {
                    console.log('Placing order...');

                    // Final validation
                    if (!this.selectedPayment) {
                        this.showNotification('Please select a payment method', 'error');
                        return;
                    }

                    // Validate delivery info once more
                    this.errors = { name: '', phone: '', address: '' };
                    let isValid = true;

                    if (!this.deliveryInfo.name.trim()) {
                        this.errors.name = 'Full name is required';
                        isValid = false;
                    }
                    if (!this.deliveryInfo.phone.trim()) {
                        this.errors.phone = 'Phone number is required';
                        isValid = false;
                    }
                    if (!this.deliveryInfo.address.trim()) {
                        this.errors.address = 'Delivery address is required';
                        isValid = false;
                    }

                    if (!isValid) {
                        this.showNotification('Please complete all required fields', 'error');
                        this.currentStep = 2; // Go back to delivery step
                        return;
                    }

                    this.placingOrder = true;

                    try {
                        const form = document.getElementById('checkoutForm');
                        const formData = new FormData(form);

                        console.log('Submitting order...');
                        const response = await fetch('{{ route("customer.checkout.place") }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                            body: formData
                        });

                        const data = await response.json();
                        console.log('Order response:', data);

                        if (data.success) {
                            this.showNotification('Order placed successfully!', 'success');
                            // Redirect to confirmation page
                            setTimeout(() => {
                                window.location.href = data.redirect_url;
                            }, 1500);
                        } else {
                            this.showNotification(data.message || 'Failed to place order', 'error');
                        }
                    } catch (error) {
                        console.error('Error placing order:', error);
                        this.showNotification('Error placing order. Please try again.', 'error');
                    } finally {
                        this.placingOrder = false;
                    }
                },

                showNotification(message, type = 'info') {
                    // Remove existing notifications
                    document.querySelectorAll('[data-checkout-notification]').forEach(el => el.remove());

                    // Create notification element
                    const notification = document.createElement('div');
                    notification.setAttribute('data-checkout-notification', 'true');
                    notification.className = `fixed top-4 right-4 p-4 rounded-xl text-white font-medium z-50 shadow-lg transform transition-all duration-300 ${
                        type === 'success' ? 'bg-green-500' :
                        type === 'error' ? 'bg-red-500' : 'bg-blue-500'
                    }`;
                    notification.innerHTML = `
                        <div class="flex items-center space-x-2">
                            <i class='bx ${type === 'success' ? 'bx-check-circle' : type === 'error' ? 'bx-error' : 'bx-info-circle'}'></i>
                            <span>${message}</span>
                        </div>
                    `;

                    document.body.appendChild(notification);

                    // Remove after 4 seconds
                    setTimeout(() => {
                        notification.style.opacity = '0';
                        notification.style.transform = 'translateX(100%)';
                        setTimeout(() => {
                            if (document.body.contains(notification)) {
                                document.body.removeChild(notification);
                            }
                        }, 300);
                    }, 4000);
                }
            }
        }
    </script>
</body>
</html>
