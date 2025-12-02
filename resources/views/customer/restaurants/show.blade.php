<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} - FoodOrder</title>

    @include('customer.partials.head')

    <style>
        .sticky-nav {
            position: sticky;
            top: 64px;
            z-index: 40;
            background: white;
        }

        .category-tab.active {
            border-bottom: 3px solid #22c55e;
            color: #22c55e;
            font-weight: 600;
        }

        .cart-sidebar {
            transition: transform 0.3s ease;
            transform: translateX(100%);
        }

        .cart-sidebar.open {
            transform: translateX(0);
        }

        .menu-item-card {
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .menu-item-card:hover {
            border-color: #22c55e;
            transform: translateY(-2px);
        }

        .cart-toggle-btn {
            transition: all 0.3s ease;
            box-shadow: 0 10px 25px rgba(34, 197, 94, 0.3);
        }

        .cart-toggle-btn:hover {
            transform: scale(1.05);
        }

        .quantity-controls {
            transition: all 0.2s ease;
        }

        .fade-in {
            animation: fadeIn 0.3s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .restaurant-header {
            background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
        }

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
    </style>
</head>
<body class="font-poppins bg-gray-50 min-h-screen" x-data="restaurantPage()">
    <!-- Navigation -->
    @include('customer.partials.navigation')

    <!-- Restaurant Header -->
    <div class="restaurant-header text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="py-6">
                <!-- Breadcrumb -->
                <nav class="flex items-center space-x-2 text-sm text-primary-100 mb-4">
                    <a href="{{ route('customer.restaurants') }}" class="hover:text-white transition-colors">Restaurants</a>
                    <i class='bx bx-chevron-right'></i>
                    <span class="text-white font-medium">{{ $restaurant->name }}</span>
                </nav>

                <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-6">
                    <div class="flex-1">
                        <div class="flex items-start space-x-4">
                            <!-- Restaurant Logo -->
                            <div class="w-20 h-20 bg-white/20 rounded-2xl flex items-center justify-center flex-shrink-0 backdrop-blur-sm border border-white/30">
                                @if($restaurant->logo)
                                <img src="{{ asset('storage/' . $restaurant->logo) }}"
                                     alt="{{ $restaurant->name }}"
                                     class="w-16 h-16 rounded-xl object-cover">
                                @else
                                <i class='bx bx-restaurant text-white text-3xl'></i>
                                @endif
                            </div>

                            <!-- Restaurant Info -->
                            <div class="flex-1">
                                <h1 class="text-3xl font-bold text-white mb-2">{{ $restaurant->name }}</h1>
                                <p class="text-primary-100 mb-4">{{ $restaurant->description }}</p>

                                <div class="flex flex-wrap items-center gap-4 text-sm text-primary-100">
                                    <div class="flex items-center space-x-1 bg-white/20 px-3 py-1 rounded-full backdrop-blur-sm">
                                        <i class='bx bx-star text-yellow-300'></i>
                                        <span class="font-semibold text-white">{{ number_format($restaurant->rating, 1) }}</span>
                                        <span>({{ $restaurant->total_ratings ?? 250 }}+ reviews)</span>
                                    </div>
                                    <div class="flex items-center space-x-1 bg-white/20 px-3 py-1 rounded-full backdrop-blur-sm">
                                        <i class='bx bx-time'></i>
                                        <span>{{ $restaurant->delivery_time }} min</span>
                                    </div>
                                    <div class="flex items-center space-x-1 bg-white/20 px-3 py-1 rounded-full backdrop-blur-sm">
                                        <i class='bx bx-dollar-circle'></i>
                                        <span>Rp 5,000 delivery</span>
                                    </div>
                                    <div class="flex items-center space-x-1 bg-white/20 px-3 py-1 rounded-full backdrop-blur-sm">
                                        <i class='bx bx-shopping-bag'></i>
                                        <span>Min. order: Rp 25,000</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Cart Toggle Button -->
                    <button @click="openCart = true"
                            class="cart-toggle-btn bg-white text-primary-600 hover:bg-gray-100 px-6 py-3 rounded-xl font-semibold transition flex items-center space-x-2 shadow-lg">
                        <i class='bx bx-cart text-xl'></i>
                        <span>View Cart</span>
                        <span x-text="cartCount" class="bg-primary-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm font-bold"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Category Navigation -->
    <div class="sticky-nav border-b border-gray-200 bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex space-x-8 overflow-x-auto">
                @foreach($menuItems as $categoryName => $items)
                <button class="category-tab flex-shrink-0 py-4 px-2 font-medium text-gray-500 hover:text-gray-700 transition"
                        :class="{ 'active': activeCategory === '{{ $categoryName }}' }"
                        @click="activeCategory = '{{ $categoryName }}'; scrollToCategory('{{ $categoryName }}')">
                    {{ $categoryName }} ({{ count($items) }})
                </button>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Menu Items -->
            <div class="lg:col-span-2">
                @foreach($menuItems as $categoryName => $items)
                <div id="category-{{ Str::slug($categoryName) }}"
                     x-show="activeCategory === '{{ $categoryName }}'"
                     class="mb-12 fade-in">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">{{ $categoryName }}</h2>

                    <div class="grid grid-cols-1 gap-6">
                        @foreach($items as $menuItem)
                        <div class="menu-item-card bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                            <div class="flex items-start space-x-4">
                                <!-- Food Image -->
                                <div class="w-24 h-24 bg-primary-50 rounded-xl flex items-center justify-center flex-shrink-0 border border-gray-200 overflow-hidden">
                                    @if($menuItem->image)
                                    <img src="{{ asset('storage/' . $menuItem->image) }}"
                                         alt="{{ $menuItem->name }}"
                                         class="w-full h-full object-cover">
                                    @else
                                    <div class="text-primary-600 text-3xl">🍽️</div>
                                    @endif
                                </div>

                                <!-- Food Info -->
                                <div class="flex-1">
                                    <div class="flex items-start justify-between mb-2">
                                        <div>
                                            <h3 class="font-semibold text-gray-900 text-lg">{{ $menuItem->name }}</h3>
                                            <p class="text-gray-600 text-sm mt-1">{{ $menuItem->description }}</p>
                                        </div>
                                        <span class="font-bold text-gray-900 text-lg">{{ 'Rp ' . number_format($menuItem->price, 0, ',', '.') }}</span>
                                    </div>

                                    <!-- Item Meta -->
                                    <div class="flex items-center space-x-4 text-sm text-gray-500 mb-4">
                                        <div class="flex items-center space-x-1">
                                            <i class='bx bx-star text-yellow-400'></i>
                                            <span>4.8 (150)</span>
                                        </div>
                                        <div class="flex items-center space-x-1">
                                            <i class='bx bx-time'></i>
                                            <span>15 min</span>
                                        </div>
                                        @if($menuItem->is_vegetarian)
                                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs">🌱 Vegetarian</span>
                                        @endif
                                        @if($menuItem->is_spicy)
                                        <span class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs">🌶️ Spicy</span>
                                        @endif
                                    </div>

                                    <!-- Add to Cart Section -->
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-3" x-data="{ quantity: 1 }">
                                            <div class="flex items-center space-x-2 quantity-controls">
                                                <button @click="if(quantity > 1) quantity--"
                                                        :class="quantity <= 1 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-100'"
                                                        class="w-8 h-8 rounded-full bg-gray-50 border border-gray-300 flex items-center justify-center text-gray-600 transition">
                                                    <i class='bx bx-minus text-sm'></i>
                                                </button>
                                                <span class="font-medium w-8 text-center" x-text="quantity"></span>
                                                <button @click="quantity++"
                                                        class="w-8 h-8 rounded-full bg-primary-100 text-primary-600 flex items-center justify-center hover:bg-primary-200 transition">
                                                    <i class='bx bx-plus text-sm'></i>
                                                </button>
                                            </div>
                                        </div>

                                        <button @click="addToCart({{ $menuItem->id }}, $data.quantity)"
                                                class="bg-primary-500 hover:bg-primary-600 text-white px-6 py-2 rounded-lg font-medium transition flex items-center space-x-2">
                                            <i class='bx bx-plus'></i>
                                            <span>Add to Cart</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Cart Sidebar -->
            <div class="lg:col-span-1">
                <div class="cart-sidebar fixed inset-y-0 right-0 w-full lg:w-96 bg-white shadow-2xl z-50 overflow-y-auto"
                     :class="{ 'open': openCart }"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="transform translate-x-full"
                     x-transition:enter-end="transform translate-x-0"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="transform translate-x-0"
                     x-transition:leave-end="transform translate-x-full">
                    <div class="p-6 h-full flex flex-col">
                        <!-- Cart Header -->
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-2xl font-bold text-gray-900">Your Order</h3>
                            <button @click="openCart = false" class="p-2 hover:bg-gray-100 rounded-lg transition">
                                <i class='bx bx-x text-2xl text-gray-500'></i>
                            </button>
                        </div>

                        <!-- Cart Content -->
                        <div class="flex-1 overflow-y-auto">
                            <!-- Empty Cart State -->
                            <div x-show="cartItems.length === 0" class="text-center py-12">
                                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class='bx bx-cart text-3xl text-gray-400'></i>
                                </div>
                                <p class="text-gray-600 text-lg mb-2">Your cart is empty</p>
                                <p class="text-gray-500 text-sm">Add some delicious items from the menu</p>
                            </div>

                            <!-- Cart Items -->
                            <div x-show="cartItems.length > 0" class="space-y-4">
                                <template x-for="item in cartItems" :key="item.id">
                                    <div class="bg-gray-50 rounded-xl p-4 border border-gray-200 cart-item-enter">
                                        <div class="flex items-start justify-between mb-2">
                                            <div class="flex-1">
                                                <h4 class="font-semibold text-gray-900" x-text="item.name"></h4>
                                                <p class="text-gray-600 text-sm" x-text="'Rp ' + formatPrice(item.price)"></p>
                                            </div>
                                            <p class="font-semibold text-gray-900"
                                               x-text="'Rp ' + formatPrice(item.price * item.quantity)"></p>
                                        </div>

                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center space-x-3">
                                                <button @click="updateQuantity(item.id, item.quantity - 1)"
                                                        :disabled="item.quantity <= 1"
                                                        :class="item.quantity <= 1 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-200'"
                                                        class="w-8 h-8 rounded-full bg-white border border-gray-300 flex items-center justify-center text-gray-600 transition">
                                                    <i class='bx bx-minus text-sm'></i>
                                                </button>
                                                <span class="font-medium w-8 text-center" x-text="item.quantity"></span>
                                                <button @click="updateQuantity(item.id, item.quantity + 1)"
                                                        class="w-8 h-8 rounded-full bg-primary-100 text-primary-600 flex items-center justify-center hover:bg-primary-200 transition">
                                                    <i class='bx bx-plus text-sm'></i>
                                                </button>
                                            </div>
                                            <button @click="removeFromCart(item.id)"
                                                    class="text-red-500 hover:text-red-600 transition flex items-center space-x-1 text-sm">
                                                <i class='bx bx-trash'></i>
                                                <span>Remove</span>
                                            </button>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- Cart Summary -->
                        <div x-show="cartItems.length > 0" class="border-t border-gray-200 pt-4 mt-4">
                            <div class="space-y-3 mb-4">
                                <div class="flex justify-between text-gray-600">
                                    <span>Subtotal</span>
                                    <span x-text="'Rp ' + formatPrice(subtotal)"></span>
                                </div>
                                <div class="flex justify-between text-gray-600">
                                    <span>Delivery Fee</span>
                                    <span>Rp 5,000</span>
                                </div>
                                <div class="flex justify-between text-gray-600">
                                    <span>Tax (10%)</span>
                                    <span x-text="'Rp ' + formatPrice(subtotal * 0.1)"></span>
                                </div>
                                <div class="flex justify-between font-bold text-lg text-gray-900 border-t border-gray-200 pt-2">
                                    <span>Total</span>
                                    <span x-text="'Rp ' + formatPrice(total)"></span>
                                </div>
                            </div>

                            <!-- Checkout Button -->
                            <a href="{{ route('customer.checkout') }}"
                               class="w-full bg-primary-500 hover:bg-primary-600 text-white py-4 rounded-xl font-semibold text-lg transition flex items-center justify-center space-x-2 mb-3">
                                <i class='bx bx-credit-card'></i>
                                <span>Proceed to Checkout</span>
                            </a>

                            <!-- Continue Shopping -->
                            <button @click="openCart = false"
                                    class="w-full border border-gray-300 text-gray-700 py-3 rounded-xl font-medium transition hover:bg-gray-50">
                                Continue Shopping
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Cart Overlay -->
    <div x-show="openCart"
         @click="openCart = false"
         class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
    </div>

    <!-- Footer -->
    @include('customer.partials.footer')

    <script>
        function restaurantPage() {
            return {
                activeCategory: '{{ array_keys($menuItems->toArray())[0] ?? '' }}',
                openCart: false,
                cartItems: @json($cartItems),
                subtotal: {{ $cartTotal }},
                total: {{ $cartTotal + 5000 + ($cartTotal * 0.1) }},
                cartCount: {{ $cartCount }},

                init() {
                    this.loadCart();
                },

                async loadCart() {
                    try {
                        const response = await fetch('{{ route("customer.cart.get") }}');
                        const data = await response.json();

                        if (data.success) {
                            this.cartItems = data.cart_items;
                            this.calculateTotals();
                            this.updateNavigationCart();
                        }
                    } catch (error) {
                        console.error('Error loading cart:', error);
                    }
                },

                async addToCart(menuItemId, quantity = 1) {
                    try {
                        const response = await fetch('{{ route("customer.cart.add") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                menu_item_id: menuItemId,
                                quantity: quantity
                            })
                        });

                        const data = await response.json();

                        if (data.success) {
                            await this.loadCart();
                            this.openCart = true;

                            if (data.restaurant_switched) {
                                this.showNotification(data.message + ' Now ordering from ' + data.new_restaurant, 'info');
                            } else {
                                this.showNotification('Item added to cart!', 'success');
                            }

                            // Update global navigation cart count
                            if (typeof updateGlobalCartCount === 'function') {
                                updateGlobalCartCount(data.cart_count);
                            }
                        } else {
                            this.showNotification(data.message, 'error');
                        }
                    } catch (error) {
                        console.error('Error adding to cart:', error);
                        this.showNotification('Error adding item to cart', 'error');
                    }
                },

                async updateQuantity(menuItemId, newQuantity) {
                    if (newQuantity < 1) {
                        this.removeFromCart(menuItemId);
                        return;
                    }

                    try {
                        const response = await fetch('{{ route("customer.cart.update") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                items: [{
                                    menu_item_id: menuItemId,
                                    quantity: newQuantity
                                }]
                            })
                        });

                        const data = await response.json();

                        if (data.success) {
                            await this.loadCart();

                            // Update global navigation cart count
                            if (typeof updateGlobalCartCount === 'function') {
                                updateGlobalCartCount(data.cart_count);
                            }
                        }
                    } catch (error) {
                        console.error('Error updating quantity:', error);
                    }
                },

                async removeFromCart(menuItemId) {
                    try {
                        const response = await fetch(`/cart/remove/${menuItemId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        });

                        const data = await response.json();

                        if (data.success) {
                            await this.loadCart();
                            this.showNotification('Item removed from cart', 'success');

                            // Update global navigation cart count
                            if (typeof updateGlobalCartCount === 'function') {
                                updateGlobalCartCount(data.cart_count);
                            }
                        }
                    } catch (error) {
                        console.error('Error removing from cart:', error);
                    }
                },

                calculateTotals() {
                    this.subtotal = this.cartItems.reduce((sum, item) => sum + (item.price * item.quantity), 0);
                    this.total = this.subtotal + 5000 + (this.subtotal * 0.1);
                    this.cartCount = this.cartItems.reduce((sum, item) => sum + item.quantity, 0);
                },

                updateNavigationCart() {
                    // Update cart count in navigation
                    if (typeof updateGlobalCartCount === 'function') {
                        updateGlobalCartCount(this.cartCount);
                    }
                },

                formatPrice(price) {
                    return new Intl.NumberFormat('id-ID').format(price);
                },

                scrollToCategory(categoryName) {
                    const element = document.getElementById(`category-${categoryName.replace(/\s+/g, '-').toLowerCase()}`);
                    if (element) {
                        element.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }
                },

                showNotification(message, type = 'info') {
                    // Create notification element
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

                    // Remove notification after 3 seconds
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
            }
        }
        </script>
</body>
</html>
