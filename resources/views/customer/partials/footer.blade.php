<!-- Bottom Navigation for Mobile -->
<div class="lg:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 z-40">
    <div class="flex justify-around items-center p-3">
        <a href="{{ route('home') }}" class="flex flex-col items-center text-primary-600">
            <i class='bx bx-home text-xl'></i>
            <span class="text-xs mt-1">Home</span>
        </a>
        <a href="{{ route('customer.restaurants') }}" class="flex flex-col items-center text-gray-400">
            <i class='bx bx-search text-xl'></i>
            <span class="text-xs mt-1">Search</span>
        </a>
        <a href="{{ route('customer.cart') }}" class="flex flex-col items-center text-gray-400">
            <i class='bx bx-cart text-xl'></i>
            <span class="text-xs mt-1">Cart</span>
        </a>
        @auth
        <a href="{{ route('customer.profile') }}" class="flex flex-col items-center text-gray-400">
            <i class='bx bx-user text-xl'></i>
            <span class="text-xs mt-1">Profile</span>
        </a>
        @else
        <a href="{{ route('login') }}" class="flex flex-col items-center text-gray-400">
            <i class='bx bx-user text-xl'></i>
            <span class="text-xs mt-1">Login</span>
        </a>
        @endauth
    </div>
</div>

<!-- Alpine JS -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<script>
    // Update cart count from localStorage
    document.addEventListener('DOMContentLoaded', function() {
        function updateCartCount() {
            const cart = JSON.parse(localStorage.getItem('cart') || '[]');
            const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
            const cartElement = document.getElementById('cart-count');
            if (cartElement) {
                cartElement.textContent = totalItems;
            }
        }

        updateCartCount();

        // Listen for custom cart update events
        window.addEventListener('cartUpdated', updateCartCount);
    });
</script>
