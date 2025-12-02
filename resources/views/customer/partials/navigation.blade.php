<nav class="bg-white shadow-sm border-b border-gray-100 sticky top-0 z-50"
     x-data="navSearch()"
     x-init="init()">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="flex items-center">
                    <div class="w-10 h-10 bg-primary-500 rounded-xl flex items-center justify-center">
                        <i class='bx bx-restaurant text-2xl text-white'></i>
                    </div>
                    <div class="ml-3">
                        <h1 class="text-xl font-bold text-gray-900">FoodOrder</h1>
                    </div>
                </a>
            </div>

            <!-- Search Bar - Hide on mobile -->
            <div class="flex-1 max-w-2xl mx-8 hidden lg:block relative" id="nav-search-container">
                <div class="relative">
                    <i class='bx bx-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 z-10'></i>
                    <input
                        type="text"
                        placeholder="Search restaurants or food..."
                        class="w-full pl-10 pr-12 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-700 placeholder-gray-400 focus:outline-none focus:border-primary-300 focus:ring-1 focus:ring-primary-300"
                        x-model="searchQuery"
                        @input="handleSearchInput"
                        @focus="showSuggestions = true"
                        @keydown.enter="performSearch"
                        @keydown.escape="showSuggestions = false"
                        id="nav-search-input"
                    >

                    <!-- Search Loading Indicator -->
                    <div x-show="isLoading" class="absolute right-10 top-1/2 transform -translate-y-1/2">
                        <div class="animate-spin rounded-full h-5 w-5 border-b-2 border-primary-500"></div>
                    </div>

                    <!-- Search Button -->
                    <button
                        @click="performSearch"
                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-primary-500 hover:text-primary-600 transition"
                        :class="{ 'opacity-50 cursor-not-allowed': !searchQuery.trim() }"
                        :disabled="!searchQuery.trim()"
                    >
                        <i class='bx bx-search-alt text-xl'></i>
                    </button>
                </div>

                <!-- Auto-suggest Dropdown -->
                <div
                    class="absolute top-full left-0 right-0 mt-2 bg-white rounded-xl shadow-lg border border-gray-100 z-50 max-h-96 overflow-y-auto"
                    id="nav-search-suggestions"
                    x-show="showSuggestions && (searchQuery.length > 0 || showPopular)"
                    x-transition
                    x-cloak
                >
                    <!-- Loading State -->
                    <div x-show="isLoading" class="p-6 text-center">
                        <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-primary-500"></div>
                        <p class="mt-2 text-gray-500 text-sm">Searching...</p>
                    </div>

                    <!-- Popular Suggestions -->
                    <template x-if="searchQuery.length === 0 && showPopular && !isLoading">
                        <div class="p-4 border-b border-gray-100">
                            <div class="flex items-center justify-between mb-3">
                                <h3 class="text-sm font-semibold text-gray-700 flex items-center">
                                    <i class='bx bx-trending-up text-primary-500 mr-2'></i>
                                    Popular Searches
                                </h3>
                                <button
                                    @click="togglePopular"
                                    class="text-xs text-primary-600 hover:text-primary-700"
                                >
                                    <span x-text="showPopular ? 'Hide' : 'Show All'"></span>
                                </button>
                            </div>
                            <div class="flex flex-wrap gap-2">
                                <template x-for="category in popularSuggestions.categories" :key="'nav-pop-cat-' + category.id">
                                    <button
                                        @click="selectSuggestion(category.name, 'category')"
                                        class="px-3 py-1.5 bg-primary-50 hover:bg-primary-100 text-primary-700 rounded-full text-sm flex items-center transition"
                                    >
                                        <i class='bx bx-category mr-1'></i>
                                        <span x-text="category.name"></span>
                                    </button>
                                </template>
                                <template x-for="dish in popularSuggestions.dishes" :key="'nav-pop-dish-' + dish.id">
                                    <button
                                        @click="selectSuggestion(dish.name, 'dish')"
                                        class="px-3 py-1.5 bg-orange-50 hover:bg-orange-100 text-orange-700 rounded-full text-sm flex items-center transition"
                                    >
                                        <i class='bx bx-bowl-hot mr-1'></i>
                                        <span x-text="dish.name"></span>
                                    </button>
                                </template>
                            </div>
                        </div>
                    </template>

                    <!-- Recent Searches -->
                    <template x-if="searchQuery.length === 0 && recentSearches.length > 0 && !isLoading">
                        <div class="p-4">
                            <div class="flex items-center justify-between mb-3">
                                <h3 class="text-sm font-semibold text-gray-700 flex items-center">
                                    <i class='bx bx-history text-gray-500 mr-2'></i>
                                    Recent Searches
                                </h3>
                                <button
                                    @click="clearRecentSearches"
                                    class="text-xs text-gray-500 hover:text-gray-700"
                                >
                                    Clear All
                                </button>
                            </div>
                            <div class="space-y-1">
                                <template x-for="search in recentSearches" :key="'recent-' + search.id">
                                    <button
                                        @click="selectRecentSearch(search.query)"
                                        class="w-full text-left px-3 py-2 hover:bg-gray-50 rounded-lg flex items-center justify-between transition"
                                    >
                                        <div class="flex items-center">
                                            <i class='bx bx-search text-gray-400 mr-3'></i>
                                            <span class="text-gray-700" x-text="search.query"></span>
                                        </div>
                                        <button
                                            @click.stop="removeRecentSearch(search.id)"
                                            class="text-gray-400 hover:text-gray-600"
                                        >
                                            <i class='bx bx-x text-lg'></i>
                                        </button>
                                    </button>
                                </template>
                            </div>
                        </div>
                    </template>

                    <!-- Search Results -->
                    <template x-if="searchQuery.length > 0 && !isLoading">
                        <div>
                            <!-- Restaurants -->
                            <template x-if="searchResults.restaurants.length > 0">
                                <div class="p-3 border-b border-gray-100">
                                    <div class="flex items-center mb-2">
                                        <i class='bx bx-restaurant text-green-500 mr-2'></i>
                                        <h3 class="text-sm font-semibold text-gray-700">Restaurants</h3>
                                    </div>
                                    <div class="space-y-1">
                                        <template x-for="restaurant in searchResults.restaurants" :key="'nav-res-' + restaurant.id">
                                            <button
                                                @click="selectSuggestion(restaurant.name, 'restaurant')"
                                                class="w-full text-left px-3 py-2 hover:bg-gray-50 rounded-lg flex items-center transition"
                                            >
                                                <div class="w-8 h-8 bg-gradient-to-br from-green-100 to-green-200 rounded-lg flex items-center justify-center mr-3">
                                                    <i class='bx bx-store text-green-600 text-sm'></i>
                                                </div>
                                                <div class="flex-1">
                                                    <span class="font-medium text-gray-800" x-text="restaurant.name"></span>
                                                </div>
                                                <i class='bx bx-chevron-right text-gray-400'></i>
                                            </button>
                                        </template>
                                    </div>
                                </div>
                            </template>

                            <!-- Categories -->
                            <template x-if="searchResults.categories.length > 0">
                                <div class="p-3 border-b border-gray-100">
                                    <div class="flex items-center mb-2">
                                        <i class='bx bx-category text-blue-500 mr-2'></i>
                                        <h3 class="text-sm font-semibold text-gray-700">Categories</h3>
                                    </div>
                                    <div class="space-y-1">
                                        <template x-for="category in searchResults.categories" :key="'nav-cat-' + category.id">
                                            <button
                                                @click="selectSuggestion(category.name, 'category')"
                                                class="w-full text-left px-3 py-2 hover:bg-gray-50 rounded-lg flex items-center transition"
                                            >
                                                <div class="w-8 h-8 bg-gradient-to-br from-blue-100 to-blue-200 rounded-lg flex items-center justify-center mr-3">
                                                    <i class='bx bx-category text-blue-600 text-sm'></i>
                                                </div>
                                                <div class="flex-1">
                                                    <span class="font-medium text-gray-800" x-text="category.name"></span>
                                                    <p class="text-xs text-gray-500" x-text="category.slug || ''"></p>
                                                </div>
                                                <i class='bx bx-chevron-right text-gray-400'></i>
                                            </button>
                                        </template>
                                    </div>
                                </div>
                            </template>

                            <!-- Dishes -->
                            <template x-if="searchResults.dishes.length > 0">
                                <div class="p-3">
                                    <div class="flex items-center mb-2">
                                        <i class='bx bx-food-menu text-orange-500 mr-2'></i>
                                        <h3 class="text-sm font-semibold text-gray-700">Dishes</h3>
                                    </div>
                                    <div class="space-y-1">
                                        <template x-for="dish in searchResults.dishes" :key="'nav-dish-' + dish.id">
                                            <button
                                                @click="selectSuggestion(dish.name, 'dish')"
                                                class="w-full text-left px-3 py-2 hover:bg-gray-50 rounded-lg flex items-center transition"
                                            >
                                                <div class="w-8 h-8 bg-gradient-to-br from-orange-100 to-orange-200 rounded-lg flex items-center justify-center mr-3">
                                                    <i class='bx bx-bowl-hot text-orange-600 text-sm'></i>
                                                </div>
                                                <div class="flex-1">
                                                    <span class="font-medium text-gray-800" x-text="dish.name"></span>
                                                    <p class="text-xs text-gray-500" x-text="dish.restaurant?.name || 'Various restaurants'"></p>
                                                </div>
                                                <i class='bx bx-chevron-right text-gray-400'></i>
                                            </button>
                                        </template>
                                    </div>
                                </div>
                            </template>

                            <!-- No Results -->
                            <template x-if="searchQuery.length > 2 &&
                                           searchResults.categories.length === 0 &&
                                           searchResults.restaurants.length === 0 &&
                                           searchResults.dishes.length === 0">
                                <div class="p-6 text-center">
                                    <i class='bx bx-search text-3xl text-gray-300 mb-2'></i>
                                    <p class="text-gray-500">No results found for "<span class="font-medium" x-text="searchQuery"></span>"</p>
                                    <p class="text-sm text-gray-400 mt-1">Try searching for something else</p>
                                </div>
                            </template>

                            <!-- Quick Actions -->
                            <div class="border-t border-gray-100 p-3">
                                <button
                                    @click="performSearch"
                                    class="w-full bg-primary-500 hover:bg-primary-600 text-white py-2.5 rounded-lg font-medium transition flex items-center justify-center"
                                >
                                    <i class='bx bx-search mr-2'></i>
                                    Search for "<span x-text="searchQuery"></span>"
                                </button>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Mobile Search Button -->
            <button
                class="lg:hidden p-2 text-gray-600 hover:text-primary-600 transition"
                onclick="openMobileSearch()"
            >
                <i class='bx bx-search text-2xl'></i>
            </button>

            <!-- User Menu -->
            <div class="flex items-center space-x-4">
                <!-- Cart -->
                <a href="{{ route('customer.cart') }}" class="relative p-2 text-gray-600 hover:text-primary-600 transition" id="nav-cart">
                    <i class='bx bx-cart text-2xl'></i>
                    <span class="absolute -top-1 -right-1 w-5 h-5 bg-primary-500 rounded-full text-xs flex items-center justify-center text-white" id="cart-count">
                        @php
                            $cart = session()->get('cart', []);
                            $cartCount = 0;
                            foreach ($cart as $item) {
                                $cartCount += $item['quantity'] ?? 0;
                            }
                            echo $cartCount;
                        @endphp
                    </span>
                </a>

                @auth
                <!-- User Profile -->
                <div class="relative" id="user-dropdown-container">
                    <button onclick="toggleUserDropdown()" class="flex items-center space-x-3 focus:outline-none">
                        <div class="w-10 h-10 bg-gradient-to-r from-primary-500 to-primary-600 rounded-full flex items-center justify-center">
                            <span class="text-white font-semibold text-sm">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </span>
                        </div>
                        <div class="hidden md:block text-left">
                            <p class="font-semibold text-sm text-gray-900">{{ auth()->user()->name }}</p>
                            <p class="text-gray-500 text-xs">Food Explorer</p>
                        </div>
                        <i class='bx bx-chevron-down text-gray-400'></i>
                    </button>

                    <!-- Dropdown Menu -->
                    <div id="user-dropdown"
                         class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 py-1 z-50 hidden">
                        <a href="{{ route('customer.profile') }}" class="flex items-center space-x-2 px-4 py-3 text-gray-700 hover:bg-gray-50 transition">
                            <i class='bx bx-user'></i>
                            <span>My Profile</span>
                        </a>
                        <a href="{{ route('customer.orders.index') }}" class="flex items-center space-x-2 px-4 py-3 text-gray-700 hover:bg-gray-50 transition">
                            <i class='bx bx-history'></i>
                            <span>Order History</span>
                        </a>
                        <div class="border-t border-gray-100 my-1"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="flex items-center space-x-2 px-4 py-3 text-red-600 hover:bg-red-50 transition w-full text-left">
                                <i class='bx bx-log-out'></i>
                                <span>Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
                @else
                <div class="flex items-center space-x-3">
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-primary-600 font-medium">Login</a>
                    <a href="{{ route('register') }}" class="bg-primary-500 hover:bg-primary-600 text-white px-6 py-2 rounded-lg font-medium transition">
                        Sign Up
                    </a>
                </div>
                @endauth
            </div>
        </div>
    </div>

    <!-- Mobile Search Modal -->
    <div id="mobile-search-modal" class="lg:hidden fixed inset-0 bg-white z-50 transform -translate-y-full transition-transform duration-300">
        <div class="h-16 flex items-center px-4 border-b border-gray-100">
            <button onclick="closeMobileSearch()" class="p-2 mr-3">
                <i class='bx bx-arrow-back text-2xl text-gray-600'></i>
            </button>
            <div class="flex-1">
                <div class="relative">
                    <i class='bx bx-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400'></i>
                    <input
                        type="text"
                        placeholder="Search restaurants or food..."
                        class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-700 placeholder-gray-400 focus:outline-none focus:border-primary-300 focus:ring-1 focus:ring-primary-300"
                        id="mobile-search-input"
                    >
                </div>
            </div>
        </div>
        <div id="mobile-search-results" class="p-4 overflow-y-auto max-h-[calc(100vh-4rem)]">
            <!-- Results will be loaded here -->
        </div>
    </div>
</nav>

<!-- 🎨 CSS Styles untuk Navigation Search -->
<style>
    /* Search Animation */
    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    #nav-search-suggestions {
        animation: slideDown 0.2s ease-out;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
    }

    /* Mobile Search Modal Animation */
    #mobile-search-modal.open {
        transform: translateY(0);
    }

    /* Custom Scrollbar untuk suggestions */
    #nav-search-suggestions::-webkit-scrollbar {
        width: 6px;
    }

    #nav-search-suggestions::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 3px;
    }

    #nav-search-suggestions::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 3px;
    }

    #nav-search-suggestions::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    /* Search Input Focus Effect */
    #nav-search-input:focus {
        box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.1);
    }

    /* Loading Spinner */
    .animate-spin {
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    /* Hide elements with x-cloak */
    [x-cloak] {
        display: none !important;
    }
</style>

<!-- 🚀 Alpine.js Component untuk Navigation Search -->
<script>
// Alpine.js Component untuk Navigation Search
document.addEventListener('alpine:init', () => {
    Alpine.data('navSearch', () => ({
        // State Variables
        searchQuery: '',
        searchResults: {
            categories: [],
            restaurants: [],
            dishes: []
        },
        popularSuggestions: {
            categories: [],
            dishes: []
        },
        recentSearches: [],
        isLoading: false,
        showSuggestions: false,
        showPopular: true,
        debounceTimer: null,

        // Initialize Component
        async init() {
            console.log('Alpine NavSearch initialized');

            // Load popular suggestions
            await this.loadPopularSuggestions();

            // Load recent searches from localStorage
            this.loadRecentSearches();

            // Handle clicks outside
            this.setupClickOutside();

            // Handle escape key
            this.setupKeyboardShortcuts();
        },

        // Setup click outside listener
        setupClickOutside() {
            document.addEventListener('click', (e) => {
                const searchContainer = document.getElementById('nav-search-container');
                const suggestions = document.getElementById('nav-search-suggestions');

                if (searchContainer && !searchContainer.contains(e.target)) {
                    this.showSuggestions = false;
                }
            });
        },

        // Setup keyboard shortcuts
        setupKeyboardShortcuts() {
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    this.showSuggestions = false;
                }
            });

            // Arrow key navigation
            const searchInput = document.getElementById('nav-search-input');
            if (searchInput) {
                searchInput.addEventListener('keydown', (e) => {
                    if (e.key === 'ArrowDown' || e.key === 'ArrowUp') {
                        e.preventDefault();
                        this.navigateSuggestions(e.key);
                    }
                });
            }
        },

        // Handle search input with debounce
        handleSearchInput() {
            clearTimeout(this.debounceTimer);

            if (this.searchQuery.trim().length === 0) {
                this.showPopular = true;
                this.searchResults = { categories: [], restaurants: [], dishes: [] };
                return;
            }

            this.debounceTimer = setTimeout(() => {
                if (this.searchQuery.trim().length >= 2) {
                    this.fetchSearchResults();
                    this.showPopular = false;
                }
            }, 300);
        },

        // Fetch search results from API
        async fetchSearchResults() {
            this.isLoading = true;
            this.showSuggestions = true;

            try {
                const query = this.searchQuery.trim();
                console.log('Fetching search results for:', query);

                const response = await fetch(`/api/search-suggestions?q=${encodeURIComponent(query)}`);

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const data = await response.json();
                console.log('Search results:', data);

                this.searchResults = data;
            } catch (error) {
                console.error('Error fetching search results:', error);
                this.showToast('Error loading suggestions. Please try again.', 'error');
                this.searchResults = { categories: [], restaurants: [], dishes: [] };
            } finally {
                this.isLoading = false;
            }
        },

        // Load popular suggestions
        async loadPopularSuggestions() {
            try {
                console.log('Loading popular suggestions...');
                const response = await fetch('/api/popular-suggestions');

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const data = await response.json();
                console.log('Popular suggestions:', data);

                this.popularSuggestions = data;
            } catch (error) {
                console.error('Error loading popular suggestions:', error);
                this.popularSuggestions = { categories: [], dishes: [] };
            }
        },

        // Load recent searches from localStorage
        loadRecentSearches() {
            try {
                const recent = localStorage.getItem('foodOrderRecentSearches');
                this.recentSearches = recent ? JSON.parse(recent) : [];
                console.log('Loaded recent searches:', this.recentSearches);
            } catch (error) {
                console.error('Error loading recent searches:', error);
                this.recentSearches = [];
            }
        },

        // Save search to recent searches
        saveToRecentSearches(query) {
            try {
                const trimmedQuery = query.trim();
                if (!trimmedQuery) return;

                // Filter out duplicates (case insensitive)
                const existingIndex = this.recentSearches.findIndex(
                    item => item.query.toLowerCase() === trimmedQuery.toLowerCase()
                );

                if (existingIndex !== -1) {
                    // Remove existing and add to beginning
                    this.recentSearches.splice(existingIndex, 1);
                }

                // Add new search to beginning
                this.recentSearches.unshift({
                    id: Date.now(),
                    query: trimmedQuery,
                    timestamp: new Date().toISOString()
                });

                // Keep only last 5 searches
                if (this.recentSearches.length > 5) {
                    this.recentSearches.pop();
                }

                // Save to localStorage
                localStorage.setItem('foodOrderRecentSearches', JSON.stringify(this.recentSearches));
                console.log('Saved to recent searches:', trimmedQuery);
            } catch (error) {
                console.error('Error saving to recent searches:', error);
            }
        },

        // Select a suggestion
        selectSuggestion(text, type) {
            console.log('Selected suggestion:', text, type);

            const trimmedText = text.trim();
            this.searchQuery = trimmedText;
            this.showSuggestions = false;
            this.saveToRecentSearches(trimmedText);

            let url = '{{ route("customer.restaurants") }}';
            let params = new URLSearchParams();

            switch(type) {
                case 'category':
                    params.append('category', encodeURIComponent(trimmedText));
                    break;
                case 'restaurant':
                case 'dish':
                    params.append('search', encodeURIComponent(trimmedText));
                    break;
            }

            const fullUrl = url + (params.toString() ? '?' + params.toString() : '');
            console.log('Redirecting to:', fullUrl);
            window.location.href = fullUrl;
        },

        // Select recent search
        selectRecentSearch(query) {
            this.searchQuery = query;
            this.showSuggestions = false;
            this.performSearch();
        },

        // Remove recent search
        removeRecentSearch(id) {
            this.recentSearches = this.recentSearches.filter(item => item.id !== id);
            localStorage.setItem('foodOrderRecentSearches', JSON.stringify(this.recentSearches));
        },

        // Clear all recent searches
        clearRecentSearches() {
            this.recentSearches = [];
            localStorage.removeItem('foodOrderRecentSearches');
        },

        // Perform search
        performSearch() {
            const query = this.searchQuery.trim();
            if (!query) {
                console.log('No search query');
                return;
            }

            console.log('Performing search for:', query);
            this.saveToRecentSearches(query);
            this.showSuggestions = false;

            window.location.href = `{{ route('customer.restaurants') }}?search=${encodeURIComponent(query)}`;
        },

        // Toggle popular suggestions
        togglePopular() {
            this.showPopular = !this.showPopular;
        },

        // Navigate suggestions with arrow keys
        navigateSuggestions(key) {
            const suggestions = document.querySelectorAll('#nav-search-suggestions button');
            if (suggestions.length === 0) return;

            const currentIndex = Array.from(suggestions).indexOf(document.activeElement);
            let nextIndex;

            if (key === 'ArrowDown') {
                nextIndex = currentIndex < suggestions.length - 1 ? currentIndex + 1 : 0;
            } else if (key === 'ArrowUp') {
                nextIndex = currentIndex > 0 ? currentIndex - 1 : suggestions.length - 1;
            }

            if (nextIndex !== undefined && suggestions[nextIndex]) {
                suggestions[nextIndex].focus();
            }
        },

        // Show toast notification
        showToast(message, type = 'info') {
            // Remove existing toasts
            const existingToasts = document.querySelectorAll('.nav-toast');
            existingToasts.forEach(toast => toast.remove());

            // Create toast element
            const toast = document.createElement('div');
            const typeClass = type === 'error' ? 'bg-red-50 border-red-200 text-red-800' :
                            type === 'success' ? 'bg-green-50 border-green-200 text-green-800' :
                            'bg-blue-50 border-blue-200 text-blue-800';

            toast.className = `nav-toast fixed top-4 right-4 px-4 py-3 rounded-lg shadow-lg z-50 flex items-center space-x-2 ${typeClass}`;

            const icon = type === 'error' ? 'bx-error-circle' :
                        type === 'success' ? 'bx-check-circle' : 'bx-info-circle';

            toast.innerHTML = `
                <i class='bx ${icon}'></i>
                <span>${message}</span>
                <button onclick="this.parentElement.remove()" class="ml-2 text-gray-500 hover:text-gray-700">
                    <i class='bx bx-x'></i>
                </button>
            `;

            document.body.appendChild(toast);

            // Auto remove after 3 seconds
            setTimeout(() => {
                if (toast.parentElement) {
                    toast.remove();
                }
            }, 3000);
        }
    }));
});
</script>

<!-- 🚀 JavaScript untuk Mobile Search -->
<script>
// Mobile Search Functions
let mobileDebounceTimer = null;

function openMobileSearch() {
    const modal = document.getElementById('mobile-search-modal');
    modal.classList.add('open');
    const input = document.getElementById('mobile-search-input');
    input.focus();
    document.body.style.overflow = 'hidden';

    // Clear previous results
    document.getElementById('mobile-search-results').innerHTML = '';

    // Add event listener for input
    input.addEventListener('input', handleMobileSearchInput);
    input.addEventListener('keydown', (e) => {
        if (e.key === 'Enter') {
            performMobileSearch();
        }
    });
}

function closeMobileSearch() {
    const modal = document.getElementById('mobile-search-modal');
    modal.classList.remove('open');
    document.body.style.overflow = '';

    const input = document.getElementById('mobile-search-input');
    input.value = '';
    input.removeEventListener('input', handleMobileSearchInput);
}

function handleMobileSearchInput(e) {
    clearTimeout(mobileDebounceTimer);
    const query = e.target.value.trim();

    if (query.length === 0) {
        document.getElementById('mobile-search-results').innerHTML = '';
        return;
    }

    mobileDebounceTimer = setTimeout(() => {
        if (query.length >= 2) {
            fetchMobileSearchResults(query);
        }
    }, 300);
}

async function fetchMobileSearchResults(query) {
    try {
        const response = await fetch(`/api/search-suggestions?q=${encodeURIComponent(query)}`);
        if (!response.ok) throw new Error('Network response was not ok');

        const data = await response.json();
        displayMobileResults(query, data);
    } catch (error) {
        console.error('Error fetching mobile search results:', error);
        showMobileError();
    }
}

function displayMobileResults(query, data) {
    const resultsContainer = document.getElementById('mobile-search-results');
    let html = '';

    if (data.restaurants.length > 0) {
        html += `
            <div class="mb-6">
                <h3 class="text-sm font-semibold text-gray-700 mb-3">Restaurants</h3>
                <div class="space-y-2">
                    ${data.restaurants.map(restaurant => `
                        <a href="{{ route('customer.restaurants') }}?search=${encodeURIComponent(restaurant.name)}"
                           class="block p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-gradient-to-br from-green-100 to-green-200 rounded-lg flex items-center justify-center mr-3">
                                    <i class='bx bx-store text-green-600'></i>
                                </div>
                                <span class="font-medium text-gray-800">${restaurant.name}</span>
                            </div>
                        </a>
                    `).join('')}
                </div>
            </div>
        `;
    }

    if (data.categories.length > 0) {
        html += `
            <div class="mb-6">
                <h3 class="text-sm font-semibold text-gray-700 mb-3">Categories</h3>
                <div class="flex flex-wrap gap-2">
                    ${data.categories.map(category => `
                        <a href="{{ route('customer.restaurants') }}?category=${encodeURIComponent(category.name)}"
                           class="px-4 py-2 bg-blue-50 hover:bg-blue-100 text-blue-700 rounded-lg text-sm">
                            ${category.name}
                        </a>
                    `).join('')}
                </div>
            </div>
        `;
    }

    if (data.dishes.length > 0) {
        html += `
            <div>
                <h3 class="text-sm font-semibold text-gray-700 mb-3">Dishes</h3>
                <div class="space-y-2">
                    ${data.dishes.map(dish => `
                        <a href="{{ route('customer.restaurants') }}?search=${encodeURIComponent(dish.name)}"
                           class="block p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-gradient-to-br from-orange-100 to-orange-200 rounded-lg flex items-center justify-center mr-3">
                                        <i class='bx bx-bowl-hot text-orange-600'></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-800">${dish.name}</p>
                                        <p class="text-xs text-gray-500">${dish.restaurant?.name || 'Various restaurants'}</p>
                                    </div>
                                </div>
                                <i class='bx bx-chevron-right text-gray-400'></i>
                            </div>
                        </a>
                    `).join('')}
                </div>
            </div>
        `;
    }

    if (html === '') {
        html = `
            <div class="text-center py-8">
                <i class='bx bx-search text-4xl text-gray-300 mb-3'></i>
                <p class="text-gray-500">No results found for "${query}"</p>
                <p class="text-sm text-gray-400 mt-2">Try different keywords</p>
            </div>
        `;
    }

    resultsContainer.innerHTML = html;
}

function showMobileError() {
    const resultsContainer = document.getElementById('mobile-search-results');
    resultsContainer.innerHTML = `
        <div class="text-center py-8">
            <i class='bx bx-error text-4xl text-red-300 mb-3'></i>
            <p class="text-red-500">Error loading search results</p>
            <p class="text-sm text-gray-400 mt-2">Please try again</p>
        </div>
    `;
}

function performMobileSearch() {
    const query = document.getElementById('mobile-search-input').value.trim();
    if (!query) return;

    closeMobileSearch();
    window.location.href = `{{ route('customer.restaurants') }}?search=${encodeURIComponent(query)}`;
}

// User dropdown functions (existing code)
let dropdownTimeout;

function toggleUserDropdown() {
    const dropdown = document.getElementById('user-dropdown');
    if (dropdown.classList.contains('hidden')) {
        clearTimeout(dropdownTimeout);
        dropdown.classList.remove('hidden');
        setTimeout(() => {
            document.addEventListener('click', closeDropdownOnClickOutside);
        }, 10);
    } else {
        closeUserDropdown();
    }
}

function closeUserDropdown() {
    const dropdown = document.getElementById('user-dropdown');
    dropdown.classList.add('hidden');
    document.removeEventListener('click', closeDropdownOnClickOutside);
}

function closeDropdownOnClickOutside(event) {
    const dropdownContainer = document.getElementById('user-dropdown-container');
    const dropdown = document.getElementById('user-dropdown');

    if (!dropdownContainer.contains(event.target) && !dropdown.contains(event.target)) {
        closeUserDropdown();
    }
}

// Close dropdown when clicking escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeUserDropdown();
    }
});

// Auto-close dropdown after 5 seconds if mouse leaves
document.getElementById('user-dropdown-container')?.addEventListener('mouseleave', function() {
    dropdownTimeout = setTimeout(() => {
        closeUserDropdown();
    }, 5000);
});

// Cancel timeout when mouse enters dropdown
document.getElementById('user-dropdown')?.addEventListener('mouseenter', function() {
    clearTimeout(dropdownTimeout);
});

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    console.log('Navigation loaded');

    // Close any open dropdowns
    closeUserDropdown();
});
</script>
