<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} - FoodOrder</title>

    @include('customer.partials.head')

    <style>
        .cart-item-enter {
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

        .empty-cart {
            transition: all 0.3s ease;
        }

        .quantity-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .remove-btn:hover {
            transform: scale(1.1);
        }
    </style>
</head>
<body class="font-poppins bg-gray-50 min-h-screen">
    <!-- Navigation -->
    @include('customer.partials.navigation')

    <!-- Main Content -->
    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Shopping Cart</h1>
            <p class="text-gray-600">Review your order before checkout</p>
        </div>

        @if(count($cartItems) > 0)
        <!-- Restaurant Info -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 mb-6">
            <div class="flex items-center space-x-4">
                <div class="w-16 h-16 bg-primary-50 rounded-xl flex items-center justify-center flex-shrink-0 border border-gray-200">
                    @if($cartItems[0]['menu_item']->restaurant->logo)
                    <img src="{{ asset('storage/' . $cartItems[0]['menu_item']->restaurant->logo) }}"
                         alt="{{ $cartItems[0]['menu_item']->restaurant->name }}"
                         class="w-12 h-12 rounded-lg object-cover">
                    @else
                    <i class='bx bx-restaurant text-primary-600 text-2xl'></i>
                    @endif
                </div>
                <div class="flex-1">
                    <h2 class="text-xl font-semibold text-gray-900">{{ $cartItems[0]['menu_item']->restaurant->name }}</h2>
                    <p class="text-gray-600 text-sm">{{ $cartItems[0]['menu_item']->restaurant->description }}</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-600">{{ count($cartItems) }} items</p>
                    <p class="text-lg font-semibold text-primary-600">{{ 'Rp ' . number_format($total, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Cart Items -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Order Items</h2>

                    <div class="space-y-4" id="cart-items-container">
                        @foreach($cartItems as $cartItem)
                        <div class="flex items-center space-x-4 py-4 border-b border-gray-100 cart-item-enter">
                            <!-- Item Image -->
                            <div class="w-20 h-20 bg-primary-50 rounded-xl flex items-center justify-center flex-shrink-0 border border-gray-200 overflow-hidden">
                                @if($cartItem['menu_item']->image)
                                <img src="{{ asset('storage/' . $cartItem['menu_item']->image) }}"
                                     alt="{{ $cartItem['menu_item']->name }}"
                                     class="w-full h-full object-cover">
                                @else
                                <div class="text-primary-600 text-2xl">🍽️</div>
                                @endif
                            </div>

                            <!-- Item Info -->
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-900">{{ $cartItem['menu_item']->name }}</h3>
                                <p class="text-gray-600 text-sm">{{ 'Rp ' . number_format($cartItem['menu_item']->price, 0, ',', '.') }}</p>

                                <div class="flex items-center space-x-3 mt-2">
                                    <button class="quantity-btn w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 hover:bg-gray-200 transition"
                                            data-action="decrease"
                                            data-item-id="{{ $cartItem['menu_item']->id }}"
                                            {{ $cartItem['quantity'] <= 1 ? 'disabled' : '' }}>
                                        <i class='bx bx-minus text-sm'></i>
                                    </button>
                                    <span class="font-medium quantity-display w-8 text-center"
                                          data-item-id="{{ $cartItem['menu_item']->id }}">
                                        {{ $cartItem['quantity'] }}
                                    </span>
                                    <button class="quantity-btn w-8 h-8 rounded-full bg-primary-100 text-primary-600 flex items-center justify-center hover:bg-primary-200 transition"
                                            data-action="increase"
                                            data-item-id="{{ $cartItem['menu_item']->id }}">
                                        <i class='bx bx-plus text-sm'></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Item Total -->
                            <div class="text-right">
                                <p class="font-semibold text-gray-900 item-total"
                                   data-item-id="{{ $cartItem['menu_item']->id }}">
                                    {{ 'Rp ' . number_format($cartItem['total_price'], 0, ',', '.') }}
                                </p>
                                <button class="remove-btn text-red-500 hover:text-red-600 text-sm mt-1 transition flex items-center space-x-1"
                                        data-item-id="{{ $cartItem['menu_item']->id }}">
                                    <i class='bx bx-trash'></i>
                                    <span>Remove</span>
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Clear Cart Button -->
                    <div class="mt-6 pt-4 border-t border-gray-100">
                        <button id="clear-cart-btn"
                                class="text-red-500 hover:text-red-600 transition flex items-center space-x-2">
                            <i class='bx bx-trash'></i>
                            <span>Clear All Items</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 sticky top-32">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Order Summary</h3>

                    <div class="space-y-3 mb-4">
                        <div class="flex justify-between text-gray-600">
                            <span>Subtotal</span>
                            <span id="subtotal">{{ 'Rp ' . number_format($total, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Delivery Fee</span>
                            <span>Rp 5,000</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Tax (10%)</span>
                            <span id="tax">{{ 'Rp ' . number_format($total * 0.1, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 pt-4 mb-6">
                        <div class="flex justify-between font-bold text-lg text-gray-900">
                            <span>Total</span>
                            <span id="grand-total">{{ 'Rp ' . number_format($total + 5000 + ($total * 0.1), 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <a href="{{ route('customer.checkout') }}" class="w-ful bg-primary-500 hover:bg-primary-600 text-white py-3 rounded-xl font-medium text-center block transition mb-4">
                        Proceed to Checkout
                    </a>

                    <a href="{{ route('customer.restaurants') }}" class="w-full border border-gray-300 text-gray-700 py-3 rounded-xl font-medium text-center block transition hover:bg-gray-50">
                        Continue Shopping
                    </a>
                </div>
            </div>
        </div>
        @else
        <!-- Empty Cart -->
        <div class="bg-white rounded-2xl p-12 text-center shadow-sm border border-gray-100 empty-cart">
            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class='bx bx-cart text-3xl text-gray-400'></i>
            </div>
            <h3 class="text-2xl font-semibold text-gray-900 mb-2">Your cart is empty</h3>
            <p class="text-gray-600 mb-8">Looks like you haven't added any items to your cart yet</p>
            <a href="{{ route('customer.restaurants') }}" class="bg-primary-500 hover:bg-primary-600 text-white px-8 py-4 rounded-xl font-semibold text-lg transition inline-block">
                Explore Restaurants
            </a>
        </div>
        @endif
    </main>

    <!-- Footer -->
    @include('customer.partials.footer')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Update global cart count
            function updateGlobalCartCount(count) {
                const cartCountElement = document.getElementById('cart-count');
                if (cartCountElement) {
                    cartCountElement.textContent = count;
                }
            }

            // Show notification
            function showNotification(message, type = 'info') {
                const notification = document.createElement('div');
                notification.className = `fixed top-4 right-4 p-4 rounded-xl text-white font-medium z-50 shadow-lg ${
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

                setTimeout(() => {
                    notification.style.opacity = '0';
                    notification.style.transform = 'translateX(100%)';
                    setTimeout(() => {
                        if (notification.parentNode) {
                            notification.parentNode.removeChild(notification);
                        }
                    }, 300);
                }, 3000);
            }

            // Update cart totals
            function updateCartTotals(subtotal, tax, grandTotal) {
                document.getElementById('subtotal').textContent = 'Rp ' + formatPrice(subtotal);
                document.getElementById('tax').textContent = 'Rp ' + formatPrice(tax);
                document.getElementById('grand-total').textContent = 'Rp ' + formatPrice(grandTotal);
            }

            // Format price
            function formatPrice(price) {
                return new Intl.NumberFormat('id-ID').format(price);
            }

            // Quantity buttons
            document.querySelectorAll('.quantity-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const action = this.getAttribute('data-action');
                    const itemId = this.getAttribute('data-item-id');
                    const quantityDisplay = document.querySelector(`.quantity-display[data-item-id="${itemId}"]`);
                    let quantity = parseInt(quantityDisplay.textContent);

                    if (action === 'increase') {
                        quantity++;
                    } else if (action === 'decrease' && quantity > 1) {
                        quantity--;
                    }

                    if (quantity >= 1) {
                        updateCartItem(itemId, quantity);
                    }
                });
            });

            // Remove buttons
            document.querySelectorAll('.remove-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const itemId = this.getAttribute('data-item-id');
                    if (confirm('Are you sure you want to remove this item from your cart?')) {
                        removeCartItem(itemId);
                    }
                });
            });

            // Clear cart button
            document.getElementById('clear-cart-btn')?.addEventListener('click', function() {
                if (confirm('Are you sure you want to clear all items from your cart?')) {
                    clearCart();
                }
            });

            function updateCartItem(itemId, quantity) {
                fetch('{{ route("customer.cart.update") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        items: [{
                            menu_item_id: parseInt(itemId),
                            quantity: quantity
                        }]
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update UI
                        updateGlobalCartCount(data.cart_count);

                        // Reload page to reflect changes
                        location.reload();
                    }
                })
                .catch(error => {
                    console.error('Error updating cart:', error);
                    showNotification('Error updating cart. Please try again.', 'error');
                });
            }

            function removeCartItem(itemId) {
                fetch(`/cart/remove/${itemId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        updateGlobalCartCount(data.cart_count);
                        showNotification('Item removed from cart', 'success');

                        // Reload page to reflect changes
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    }
                })
                .catch(error => {
                    console.error('Error removing item:', error);
                    showNotification('Error removing item. Please try again.', 'error');
                });
            }

            function clearCart() {
                fetch('{{ route("customer.cart.clear") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        updateGlobalCartCount(0);
                        showNotification('Cart cleared successfully', 'success');

                        // Redirect to empty cart state
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    }
                })
                .catch(error => {
                    console.error('Error clearing cart:', error);
                    showNotification('Error clearing cart. Please try again.', 'error');
                });
            }

            // Initialize cart count
            updateGlobalCartCount({{ array_sum(array_column($cartItems, 'quantity')) }});
        });
    </script>
</body>
</html>
