<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>

    @include('customer.partials.head')

    <style>
        /* 🎨 Enhanced Color System dari home */
        :root {
            --appetite-orange: #FB923C;
            --fresh-green: #22C55E;
            --warm-yellow: #F59E0B;
            --trust-blue: #3B82F6;
            --gradient-primary: linear-gradient(135deg, #FF6B6B 0%, #FFA726 50%, #66BB6A 100%);
        }

        /* Header Gradient */
        .header-gradient {
            background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
        }

        /* Smart Search Container */
        .search-container {
            position: relative;
            max-width: 600px;
            margin: 0 auto 2rem;
        }

        .search-wrapper {
            position: relative;
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border: 2px solid transparent;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            padding: 0 16px;
        }

        .search-wrapper.focused {
            border-color: var(--fresh-green);
            box-shadow: 0 4px 30px rgba(34, 197, 94, 0.15);
        }

        .search-input {
            flex: 1;
            padding: 18px 0;
            border: none;
            outline: none;
            font-size: 1rem;
            background: transparent;
            color: #333;
            width: 100%;
        }

        .search-input::placeholder {
            color: #94a3b8;
            transition: color 0.3s ease;
        }

        .search-icon {
            font-size: 1.3rem;
            color: #94a3b8;
            margin-right: 12px;
        }

        .clear-search-btn {
            background: none;
            border: none;
            color: #64748b;
            cursor: pointer;
            padding: 8px;
            border-radius: 50%;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-left: 8px;
        }

        .clear-search-btn:hover {
            background: #f1f5f9;
            color: #ef4444;
        }

        .clear-search-btn i {
            font-size: 1.2rem;
        }

        .search-btn {
            background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 12px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
            margin-left: 8px;
        }

        .search-btn:hover {
            background: linear-gradient(135deg, #16a34a 0%, #15803d 100%);
            transform: translateY(-2px);
        }

        /* Active Search Badge */
        .active-search-badge {
            background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-top: 16px;
            box-shadow: 0 4px 12px rgba(34, 197, 94, 0.3);
        }

        .active-search-badge button {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            cursor: pointer;
            padding: 2px;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.3s ease;
        }

        .active-search-badge button:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        /* Restaurant Card Styles */
        .restaurant-card {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            border: 1px solid rgba(0,0,0,0.05);
            border-radius: 20px;
            overflow: hidden;
            background: white;
        }

        .restaurant-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            border-color: rgba(34, 197, 94, 0.2);
        }

        .card-badge {
            position: absolute;
            top: 15px;
            left: 15px;
            background: linear-gradient(135deg, var(--appetite-orange), var(--warm-yellow));
            color: white;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            z-index: 20;
            box-shadow: 0 4px 12px rgba(251, 146, 60, 0.3);
            backdrop-filter: blur(4px);
            border: 1px solid rgba(255,255,255,0.2);
        }

        .card-image {
            height: 200px;
            position: relative;
            overflow: hidden;
        }

        .card-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.7s ease;
        }

        .restaurant-card:hover .card-image img {
            transform: scale(1.1);
        }

        /* Restaurant Carousel untuk Recommendations */
        .restaurant-carousel {
            display: flex;
            gap: 20px;
            overflow-x: auto;
            padding: 10px 0 20px;
            scrollbar-width: thin;
            scrollbar-color: #d1d5db transparent;
            -webkit-overflow-scrolling: touch;
        }

        .restaurant-carousel::-webkit-scrollbar {
            height: 6px;
        }

        .restaurant-carousel::-webkit-scrollbar-track {
            background: #f3f4f6;
            border-radius: 3px;
        }

        .restaurant-carousel::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 3px;
        }

        .restaurant-carousel::-webkit-scrollbar-thumb:hover {
            background: #9ca3af;
        }

        .restaurant-carousel .restaurant-card {
            min-width: 280px;
            flex-shrink: 0;
        }

        .restaurant-carousel .card-image {
            height: 160px;
        }

        .restaurant-carousel .overlay-gradient {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 50%;
            background: linear-gradient(transparent, rgba(0,0,0,0.2));
            z-index: 1;
        }

        /* Filter Sidebar */
        .filter-sidebar {
            scrollbar-width: thin;
            scrollbar-color: #d1d5db #f3f4f6;
        }

        .filter-sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .filter-sidebar::-webkit-scrollbar-track {
            background: #f3f4f6;
            border-radius: 3px;
        }

        .filter-sidebar::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 3px;
        }

        .chip.active {
            background-color: #22c55e;
            color: white;
            box-shadow: 0 2px 8px rgba(34, 197, 94, 0.3);
        }

        .price-slider::-webkit-slider-thumb {
            appearance: none;
            height: 18px;
            width: 18px;
            border-radius: 50%;
            background: #22c55e;
            cursor: pointer;
            border: 2px solid white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        /* Enhanced Buttons */
        .btn-primary {
            background: linear-gradient(135deg, var(--appetite-orange), var(--warm-yellow));
            color: white;
            padding: 15px 30px;
            border-radius: 12px;
            border: none;
            font-weight: 600;
            font-size: 1.1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s;
        }

        .btn-primary:hover::before {
            left: 100%;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(251, 146, 60, 0.4);
        }

        /* Badge Styles */
        .rating-badge {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
        }

        .popular-badge {
            background: linear-gradient(135deg, #fb923c 0%, #ea580c 100%);
            color: white;
        }

        .discount-badge {
            background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
            color: white;
        }

        .delivery-badge {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            color: white;
        }

        /* Action Button */
        .action-button {
            background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
            transition: all 0.3s ease;
            color: white;
            padding: 12px 24px;
            border-radius: 12px;
            border: none;
            font-weight: 600;
            cursor: pointer;
        }

        .action-button:hover {
            background: linear-gradient(135deg, #16a34a 0%, #15803d 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(34, 197, 94, 0.3);
        }

        /* Mobile Responsiveness */
        @media (max-width: 768px) {
            .search-container {
                margin: 0 1rem 2rem;
            }

            .search-input {
                padding: 16px 0;
                font-size: 0.95rem;
            }

            .search-wrapper {
                padding: 0 12px;
            }

            .restaurant-carousel .restaurant-card {
                min-width: 250px;
            }

            .restaurant-carousel .card-image {
                height: 140px;
            }
        }

        /* Toast Styles */
        .custom-toast {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 16px 24px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            gap: 12px;
            z-index: 9999;
            animation: slideInRight 0.3s ease-out;
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(100%);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .animate-fade-in {
            animation: fade-in 0.3s ease-out;
        }

        @keyframes fade-in {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Status Indicators */
        .status-open {
            background-color: #dcfce7;
            color: #166534;
        }

        .status-closed {
            background-color: #fee2e2;
            color: #dc2626;
        }

        .status-busy {
            background-color: #fef3c7;
            color: #d97706;
        }

        /* Line Clamp Utilities */
        .line-clamp-1 {
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
        }

        .line-clamp-2 {
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .line-clamp-3 {
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
        }
    </style>
</head>
<body class="font-poppins bg-gray-50">
    <!-- Navigation -->
    @include('customer.partials.navigation')

    <!-- Page Header -->
    <section class="header-gradient text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <!-- Search Bar di Header -->
                <div class="search-container">
                    <form id="mainSearchForm" action="{{ route('customer.restaurants') }}" method="GET" class="mb-6">
                        <div class="search-wrapper" id="searchWrapper">
                            <i class='bx bx-search search-icon'></i>
                            <input
                                type="text"
                                name="search"
                                id="mainSearchInput"
                                class="search-input"
                                placeholder="Search restaurants or food..."
                                value="{{ request('search') }}"
                                autocomplete="off"
                            >
                            @if(request('search'))
                                <button type="button" class="clear-search-btn" onclick="clearSearch()" title="Clear search">
                                    <i class='bx bx-x'></i>
                                </button>
                            @endif
                            <button type="submit" class="search-btn">
                                <i class='bx bx-search'></i>
                                Search
                            </button>
                        </div>

                        @if(request('search'))
                            <div class="text-center">
                                <div class="active-search-badge inline-flex">
                                    <span>Searching for: "{{ request('search') }}"</span>
                                    <button type="button" onclick="clearSearch()" title="Clear search">
                                        <i class='bx bx-x'></i>
                                    </button>
                                </div>
                            </div>
                        @endif
                    </form>
                </div>

                @if(request('search'))
                    <h1 class="text-4xl md:text-5xl font-bold mb-4">
                        🔍 Results for "{{ request('search') }}"
                    </h1>
                    <p class="text-xl text-primary-100">
                        <span class="font-semibold">{{ $restaurants->count() }}</span> restaurants found
                    </p>
                @elseif(request('category'))
                    <h1 class="text-4xl md:text-5xl font-bold mb-4">
                        {{ request('category') }} Restaurants
                    </h1>
                    <p class="text-xl text-primary-100">
                        Discover amazing {{ strtolower(request('category')) }} cuisine
                    </p>
                @else
                    <h1 class="text-4xl md:text-5xl font-bold mb-4">
                        🍽️ Restaurants Near You
                    </h1>
                    <p class="text-xl text-primary-100">
                        Discover great food delivered to your doorstep
                    </p>
                @endif
            </div>

            <!-- Quick Actions -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mt-8">
                <button onclick="toggleFilters()" class="bg-white hover:bg-gray-50 flex items-center gap-2 px-6 py-3 text-gray-700 rounded-xl font-semibold transition-all duration-300 shadow-sm">
                    <i class='bx bx-filter-alt text-lg text-primary-500'></i>
                    Filters
                    <span class="bg-primary-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm shadow-sm" id="filter-count">
                        {{ count(request('categories', [])) + (request('min_rating') ? 1 : 0) + (request('delivery_time') ? 1 : 0) + (request('vegetarian') || request('vegan') || request('halal') ? 1 : 0) }}
                    </span>
                </button>

                <select onchange="applySorting(this.value)" class="bg-white hover:bg-gray-50 px-4 py-3 text-gray-700 rounded-xl font-semibold focus:outline-none focus:ring-2 focus:ring-primary-500 min-w-[200px] shadow-sm">
                    <option value="recommended" {{ request('sort') == 'recommended' ? 'selected' : '' }}>Recommended</option>
                    <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Highest Rated</option>
                    <option value="delivery_time" {{ request('sort') == 'delivery_time' ? 'selected' : '' }}>Fastest Delivery</option>
                    <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                </select>

                <div class="flex gap-1 bg-white rounded-xl shadow-sm p-1">
                    <button onclick="setViewMode('grid')" class="p-2 rounded-lg hover:bg-primary-500 hover:text-white transition-all duration-300">
                        <i class='bx bx-grid-alt text-xl text-primary-500 hover:text-white'></i>
                    </button>
                    <button onclick="setViewMode('list')" class="p-2 rounded-lg hover:bg-primary-500 hover:text-white transition-all duration-300">
                        <i class='bx bx-list-ul text-xl text-primary-500 hover:text-white'></i>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- 🔍 Filter Sidebar -->
            <div id="filterSidebar" class="lg:w-80 flex-shrink-0 hidden lg:block">
                <div class="filter-sidebar bg-white rounded-2xl p-6 shadow-md border border-gray-100 sticky top-24 max-h-[calc(100vh-140px)] overflow-y-auto">
                    <div class="flex justify-between items-center mb-6 pb-4 border-b border-gray-200">
                        <h3 class="text-xl font-bold text-gray-900">🔍 Filters</h3>
                        <button onclick="clearAllFilters()" class="text-primary-600 font-semibold text-sm hover:text-primary-700 transition-colors duration-200">
                            Clear All
                        </button>
                    </div>

                    <form id="filterForm" action="{{ route('customer.restaurants') }}" method="GET">
                        @if(request('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif

                        <!-- Location & Delivery -->
                        <div class="mb-6 pb-4 border-b border-gray-200">
                            <h4 class="font-semibold text-gray-800 mb-3">📍 Delivery Time</h4>
                            <div class="flex flex-wrap gap-2">
                                @php
                                    $deliveryTimes = [
                                        30 => 'Under 30 min',
                                        45 => '30-45 min',
                                        60 => '45-60 min'
                                    ];
                                @endphp
                                @foreach($deliveryTimes as $time => $label)
                                    <button type="button"
                                            class="chip px-3 py-2 bg-gray-100 rounded-full text-sm font-medium transition-all duration-300 {{ request('delivery_time') == $time ? 'active' : 'hover:bg-gray-200' }}"
                                            onclick="setDeliveryTime({{ $time }})">
                                        {{ $label }}
                                    </button>
                                @endforeach
                                <input type="hidden" name="delivery_time" id="deliveryTime" value="{{ request('delivery_time') }}">
                            </div>
                        </div>

                        <!-- Cuisine Categories -->
                        <div class="mb-6 pb-4 border-b border-gray-200">
                            <h4 class="font-semibold text-gray-800 mb-3">🍽️ Cuisine Type</h4>
                            <div class="grid grid-cols-2 gap-3">
                                @foreach($categories as $category)
                                    <label class="category-card cursor-pointer">
                                        <input type="checkbox"
                                               name="categories[]"
                                               value="{{ $category->name }}"
                                               class="hidden"
                                               {{ in_array($category->name, request('categories', [])) ? 'checked' : '' }}
                                               onchange="applyFilters()">
                                        <div class="category-content p-3 border-2 border-gray-200 rounded-xl text-center transition-all duration-300 hover:border-primary-300">
                                            <i class='category-icon {{ $category->icon }} text-2xl mb-2 {{ in_array($category->name, request('categories', [])) ? 'text-primary-500' : 'text-gray-500' }}'></i>
                                            <div class="font-semibold text-gray-800 text-sm">{{ $category->name }}</div>
                                            <div class="text-gray-500 text-xs mt-1">{{ $category->menu_items_count }} items</div>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Price Range -->
                        <div class="mb-6 pb-4 border-b border-gray-200">
                            <h4 class="font-semibold text-gray-800 mb-3">💰 Price Range</h4>
                            <div class="space-y-4">
                                <div class="flex justify-between text-lg mb-2">
                                    <span class="text-gray-500">💰</span>
                                    <span class="text-gray-500">💰💰</span>
                                    <span class="text-gray-500">💰💰💰</span>
                                    <span class="text-gray-500">💰💰💰💰</span>
                                </div>
                                <input type="range"
                                       min="1"
                                       max="4"
                                       value="{{ request('price_range', 2) }}"
                                       name="price_range"
                                       class="price-slider w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer"
                                       onchange="applyFilters()">
                            </div>
                        </div>

                        <!-- Rating Filter -->
                        <div class="mb-6 pb-4 border-b border-gray-200">
                            <h4 class="font-semibold text-gray-800 mb-3">⭐ Minimum Rating</h4>
                            <div class="space-y-2">
                                @php
                                    $ratingOptions = [
                                        '4.5' => '4.5+',
                                        '4.0' => '4.0+',
                                        '3.5' => '3.5+'
                                    ];
                                @endphp
                                @foreach($ratingOptions as $value => $label)
                                    <label class="flex items-center gap-3 p-2 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors duration-200">
                                        <input type="radio"
                                               name="min_rating"
                                               value="{{ $value }}"
                                               class="text-primary-500 focus:ring-primary-500"
                                               {{ request('min_rating') == $value ? 'checked' : '' }}
                                               onchange="applyFilters()">
                                        <div class="flex items-center gap-1 text-amber-500">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= floor($value))
                                                    <i class='bx bxs-star text-sm'></i>
                                                @elseif($i == ceil($value) && !is_int($value))
                                                    <i class='bx bxs-star-half text-sm'></i>
                                                @else
                                                    <i class='bx bx-star text-sm'></i>
                                                @endif
                                            @endfor
                                        </div>
                                        <span class="text-gray-700 font-medium text-sm">{{ $label }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Dietary Preferences -->
                        <div class="mb-2">
                            <h4 class="font-semibold text-gray-800 mb-3">🌱 Dietary</h4>
                            <div class="space-y-2">
                                @php
                                    $dietaryOptions = [
                                        'vegetarian' => 'Vegetarian',
                                        'vegan' => 'Vegan',
                                        'halal' => 'Halal'
                                    ];
                                @endphp
                                @foreach($dietaryOptions as $key => $label)
                                    <label class="flex items-center gap-3 p-2 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors duration-200">
                                        <input type="checkbox"
                                               name="{{ $key }}"
                                               value="1"
                                               class="rounded text-primary-500 focus:ring-primary-500"
                                               {{ request($key) ? 'checked' : '' }}
                                               onchange="applyFilters()">
                                        <span class="text-gray-700 text-sm">{{ $label }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- 🏪 Restaurant Listing -->
            <div class="flex-1 min-w-0">
                <!-- Active Filters Bar -->
                @php
                    $activeFilters = [];
                    if (count(request('categories', [])) > 0) {
                        foreach (request('categories', []) as $category) {
                            $activeFilters[] = [
                                'type' => 'categories',
                                'value' => $category,
                                'label' => $category,
                                'icon' => 'bx-category'
                            ];
                        }
                    }
                    if (request('min_rating')) {
                        $activeFilters[] = [
                            'type' => 'min_rating',
                            'value' => request('min_rating'),
                            'label' => '⭐ ' . request('min_rating') . '+',
                            'icon' => 'bx-star'
                        ];
                    }
                    if (request('delivery_time')) {
                        $activeFilters[] = [
                            'type' => 'delivery_time',
                            'value' => request('delivery_time'),
                            'label' => '🕐 Under ' . request('delivery_time') . ' min',
                            'icon' => 'bx-time'
                        ];
                    }
                    foreach (['vegetarian', 'vegan', 'halal'] as $dietary) {
                        if (request($dietary)) {
                            $activeFilters[] = [
                                'type' => $dietary,
                                'value' => '1',
                                'label' => '🌱 ' . ucfirst($dietary),
                                'icon' => 'bx-leaf'
                            ];
                        }
                    }
                    if (request('price_range')) {
                        $activeFilters[] = [
                            'type' => 'price_range',
                            'value' => request('price_range'),
                            'label' => '💰 Price range: ' . str_repeat('$', request('price_range')),
                            'icon' => 'bx-dollar'
                        ];
                    }
                @endphp

                @if(count($activeFilters) > 0 || request('search') || request('category'))
                    <div class="bg-white rounded-2xl p-6 shadow-md border border-gray-100 mb-6">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <div class="flex flex-wrap gap-2 flex-1">
                                <!-- Search Filter -->
                                @if(request('search'))
                                    <span class="active-filter inline-flex items-center gap-2 px-3 py-2 bg-primary-50 text-primary-600 rounded-full text-sm font-medium">
                                        <i class='bx bx-search'></i>
                                        "{{ request('search') }}"
                                        <button class="hover:text-primary-800 transition-colors duration-200"
                                                onclick="removeFilter('search', '')">
                                            <i class='bx bx-x text-lg'></i>
                                        </button>
                                    </span>
                                @endif

                                <!-- Category Filter -->
                                @if(request('category'))
                                    <span class="active-filter inline-flex items-center gap-2 px-3 py-2 bg-primary-50 text-primary-600 rounded-full text-sm font-medium">
                                        <i class='bx bx-category'></i>
                                        {{ request('category') }}
                                        <button class="hover:text-primary-800 transition-colors duration-200"
                                                onclick="removeFilter('category', '')">
                                            <i class='bx bx-x text-lg'></i>
                                        </button>
                                    </span>
                                @endif

                                <!-- Other Filters -->
                                @foreach($activeFilters as $filter)
                                    <span class="active-filter inline-flex items-center gap-2 px-3 py-2 bg-primary-50 text-primary-600 rounded-full text-sm font-medium">
                                        <i class='bx {{ $filter['icon'] }}'></i>
                                        {{ $filter['label'] }}
                                        <button class="hover:text-primary-800 transition-colors duration-200"
                                                onclick="removeFilter('{{ $filter['type'] }}', '{{ $filter['type'] == 'categories' ? $filter['value'] : '' }}')">
                                            <i class='bx bx-x text-lg'></i>
                                        </button>
                                    </span>
                                @endforeach
                            </div>
                            <div class="text-gray-600 font-medium text-sm whitespace-nowrap">
                                Showing {{ $restaurants->count() }} restaurants
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Restaurant Cards Grid -->
                @if($restaurants->count() > 0)
                    <div id="restaurantsGrid" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                        @foreach($restaurants as $restaurant)
                            <div class="restaurant-card bg-white rounded-2xl shadow-md overflow-hidden group">
                                <!-- Card Badges -->
                                <div class="absolute top-4 left-4 z-10 flex flex-col gap-2">
                                    @if($loop->first)
                                        <span class="card-badge flex items-center gap-1">
                                            <i class='bx bx-trophy'></i>
                                            #1 Most Popular
                                        </span>
                                    @endif
                                    @if($restaurant->is_open ?? true)
                                        <span class="status-open px-3 py-1 rounded-full text-xs font-semibold shadow-sm">
                                            <i class='bx bx-check-circle mr-1'></i>
                                            Open Now
                                        </span>
                                    @endif
                                </div>

                                <!-- Favorite Button -->
                                <button class="favorite-btn absolute top-4 right-4 z-10 w-10 h-10 bg-white/90 rounded-full flex items-center justify-center hover:bg-white transition-all duration-300 shadow-md"
                                        onclick="toggleFavorite(this, {{ $restaurant->id }})"
                                        title="Add to favorites">
                                    <i class='bx bx-heart text-xl text-gray-600'></i>
                                </button>

                                <!-- Restaurant Image -->
                                <a href="{{ route('customer.restaurants.show', $restaurant) }}" class="block">
                                    <div class="card-image relative overflow-hidden rounded-t-2xl">
                                        <!-- Gradient Overlay -->
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/30 via-black/10 to-transparent z-10"></div>

                                        <!-- Restaurant Image -->
                                        <img
                                            src="{{ $restaurant->cover_image_url ?? $restaurant->getCoverImageUrlAttribute() }}"
                                            alt="{{ $restaurant->name }}"
                                            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                                            loading="lazy"
                                            onerror="this.src='https://images.unsplash.com/photo-1559314809-2b99056a8c4a?auto=format&fit=crop&w=600&h=400&q=80'"
                                        >

                                        <!-- Delivery Time Badge -->
                                        <div class="absolute bottom-4 left-4 z-20 bg-white/90 backdrop-blur-sm px-3 py-1.5 rounded-full flex items-center gap-2">
                                            <i class='bx bx-time text-primary-600 text-sm'></i>
                                            <span class="text-sm font-semibold text-gray-800">{{ $restaurant->delivery_time ?? 30 }} min</span>
                                        </div>

                                        <!-- Rating Badge -->
                                        <div class="absolute top-4 right-4 z-20 bg-black/70 backdrop-blur-sm px-3 py-1.5 rounded-full flex items-center gap-1">
                                            <i class='bx bxs-star text-yellow-400 text-sm'></i>
                                            <span class="text-sm font-semibold text-white">{{ number_format($restaurant->rating ?? 4.5, 1) }}</span>
                                        </div>
                                    </div>
                                </a>

                                <!-- Card Content -->
                                <div class="p-6">
                                    <!-- Restaurant Header -->
                                    <div class="restaurant-header mb-4">
                                        <div class="flex items-start justify-between mb-2">
                                            <h3 class="font-bold text-gray-900 text-xl line-clamp-1 flex-1 mr-2">
                                                {{ $restaurant->name }}
                                            </h3>
                                            <span class="text-gray-600 font-medium flex-shrink-0">
                                                {{ $restaurant->price_range_symbol ?? '💰💰' }}
                                            </span>
                                        </div>

                                        <!-- Cuisine Tags -->
                                        <div class="flex flex-wrap gap-2 mb-3">
                                            @php
                                                $cuisineTypes = $restaurant->cuisine_types ?? $restaurant->getCuisineTypesAttribute();
                                            @endphp

                                            @if(count($cuisineTypes ?? []) > 0)
                                                @foreach(array_slice($cuisineTypes, 0, 2) as $cuisine)
                                                    <span class="cuisine-tag px-2 py-1 bg-gray-100 text-gray-600 rounded-lg text-xs font-medium">
                                                        {{ $cuisine }}
                                                    </span>
                                                @endforeach

                                                @if(count($cuisineTypes) > 2)
                                                    <span class="cuisine-tag px-2 py-1 bg-gray-100 text-gray-600 rounded-lg text-xs font-medium">
                                                        +{{ count($cuisineTypes) - 2 }} more
                                                    </span>
                                                @endif
                                            @else
                                                <span class="cuisine-tag px-2 py-1 bg-gray-100 text-gray-600 rounded-lg text-xs font-medium">
                                                    Various Cuisine
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Rating & Delivery -->
                                        <div class="flex items-center gap-4 text-gray-600 text-sm">
                                            <div class="flex items-center gap-1">
                                                <i class='bx bxs-star text-yellow-400'></i>
                                                <span>{{ number_format($restaurant->rating ?? 4.5, 1) }}</span>
                                                <span class="text-gray-400">({{ $restaurant->order_count ?? '150+' }})</span>
                                            </div>
                                            <span class="text-gray-400">•</span>
                                            <span class="flex items-center gap-1">
                                                <i class='bx bx-time'></i>
                                                {{ $restaurant->delivery_time ?? 30 }} min
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Description -->
                                    <p class="cuisine-type text-gray-500 text-sm mb-4 line-clamp-2">
                                        {{ $restaurant->description ? Str::limit($restaurant->description, 80) : 'Serving delicious food with fresh ingredients and excellent service. Experience quality dining delivered to your door.' }}
                                    </p>

                                    <!-- Restaurant Meta -->
                                    <div class="restaurant-meta flex justify-between items-center mb-4">
                                        <div class="flex items-center gap-2">
                                            <span class="price-range text-lg">
                                                {{ $restaurant->price_range_symbol ?? '💰💰' }}
                                            </span>
                                            <span class="text-gray-500 text-sm">
                                                • {{ ($restaurant->delivery_fee ?? 0) > 0 ? 'Delivery: Rp ' . number_format($restaurant->delivery_fee, 0, ',', '.') : 'Free delivery' }}
                                            </span>
                                        </div>
                                        <span class="orders-today text-sm text-gray-500 flex items-center gap-1">
                                            <i class='bx bx-trending-up text-primary-500'></i>
                                            {{ $restaurant->order_count ?? '150+' }} orders today
                                        </span>
                                    </div>

                                    <!-- Highlights -->
                                    <div class="flex flex-wrap gap-2 mb-4">
                                        @if(($restaurant->delivery_fee ?? 0) == 0)
                                            <span class="delivery-badge px-2 py-1 rounded-lg text-xs font-medium shadow-sm">
                                                🚀 Free Delivery
                                            </span>
                                        @endif
                                        @if($restaurant->has_discount ?? false)
                                            <span class="discount-badge px-2 py-1 rounded-lg text-xs font-medium shadow-sm">
                                                🎉 20% OFF
                                            </span>
                                        @endif
                                        @if(($restaurant->rating ?? 0) >= 4.5)
                                            <span class="rating-badge px-2 py-1 rounded-lg text-xs font-medium shadow-sm">
                                                ⭐ Top Rated
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Order Button -->
                                    <a href="{{ route('customer.restaurants.show', $restaurant) }}"
                                    class="order-btn w-full bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 text-white py-3 rounded-xl font-semibold transition-all duration-300 flex items-center justify-center gap-2 group/btn shadow-md hover:shadow-lg">
                                        <i class='bx bx-cart text-lg'></i>
                                        <span>View Menu</span>
                                        <i class='bx bx-chevron-right text-lg transform group-hover/btn:translate-x-1 transition-transform'></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Load More -->
                    @if($restaurants->count() >= 12)
                        <div class="text-center mt-8">
                            <button class="btn-primary py-4 px-8 rounded-xl font-semibold shadow-md hover:shadow-lg transition-all duration-300">
                                Load More Restaurants
                            </button>
                        </div>
                    @endif
                @else
                    <!-- Empty State -->
                    <div class="text-center py-16 bg-white rounded-2xl shadow-md border border-gray-100">
                        <div class="text-6xl mb-4">🍽️</div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">No restaurants found</h3>
                        <p class="text-gray-600 mb-6">Try adjusting your filters or search terms</p>
                        <button onclick="clearAllFilters()" class="action-button text-white py-3 px-6 rounded-xl font-semibold shadow-md">
                            Clear All Filters
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- 🎯 Personalized Recommendations -->
    @if(!empty($recommendations) && !request('search') && !request('category') && count($activeFilters) === 0)
        <section class="bg-gray-50 py-16 mt-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-3">🎯 Recommended For You</h2>
                    <p class="text-xl text-gray-600">Based on your preferences and current time</p>
                </div>

                @foreach($recommendations as $type => $recommendation)
                    <div class="mb-8">
                        <h4 class="text-2xl font-semibold text-gray-800 mb-6">{{ $recommendation['title'] }}</h4>
                        <div class="restaurant-carousel">
                            @foreach($recommendation['restaurants'] as $restaurant)
                                <div class="restaurant-card bg-white rounded-2xl shadow-md overflow-hidden">
                                    <!-- Card Badge -->
                                    <div class="card-badge">
                                        {{ $type === 'breakfast' ? '☀️ Best for Breakfast' : ($type === 'lunch' ? '🌞 Best for Lunch' : '🌙 Best for Dinner') }}
                                    </div>

                                    <!-- Restaurant Image -->
                                    <div class="card-image relative">
                                        <img
                                            src="{{ $restaurant->cover_image_url ?? $restaurant->getCoverImageUrlAttribute() }}"
                                            alt="{{ $restaurant->name }}"
                                            class="w-full h-full object-cover"
                                            loading="lazy"
                                            onerror="this.src='https://images.unsplash.com/photo-1559314809-2b99056a8c4a?auto=format&fit=crop&w=600&h=400&q=80'"
                                        >
                                        <div class="overlay-gradient"></div>
                                    </div>

                                    <div class="p-6">
                                        <h5 class="font-bold text-gray-900 text-lg mb-2 line-clamp-1">{{ $restaurant->name }}</h5>
                                        <p class="text-gray-600 text-sm mb-3 line-clamp-2">
                                            {{ Str::limit($restaurant->description, 60) ?: 'Various delicious foods' }}
                                        </p>
                                        <div class="text-gray-500 text-xs flex items-center gap-2">
                                            <i class='bx bxs-star text-yellow-400'></i>
                                            <span>{{ number_format($restaurant->rating, 1) }}</span>
                                            <i class='bx bx-time text-gray-400'></i>
                                            <span>{{ $restaurant->delivery_time }} min</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    <!-- Footer -->
    @include('customer.partials.footer')

    <!-- Mobile Filter Overlay -->
    <div id="mobileFilterOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden lg:hidden">
        <div class="absolute right-0 top-0 h-full w-80 bg-white overflow-y-auto">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold text-gray-900">🔍 Filters</h3>
                    <button onclick="toggleFilters()" class="text-gray-500 hover:text-gray-700 transition-colors duration-200">
                        <i class='bx bx-x text-2xl'></i>
                    </button>
                </div>
                <!-- Filter content same as desktop -->
                <div id="mobileFilterContent"></div>
            </div>
        </div>
    </div>

    <script>
        // Global functions untuk filter handling
        function clearSearch() {
            const url = new URL(window.location.href);
            url.searchParams.delete('search');
            url.searchParams.delete('category'); // Clear category too if exists
            window.location.href = url.toString();
        }

        function toggleFilters() {
            const overlay = document.getElementById('mobileFilterOverlay');
            const filterContent = document.getElementById('mobileFilterContent');
            const desktopFilters = document.querySelector('#filterSidebar .filter-sidebar');

            if (overlay.classList.contains('hidden')) {
                filterContent.innerHTML = desktopFilters.innerHTML;
                overlay.classList.remove('hidden');
            } else {
                overlay.classList.add('hidden');
            }
        }

        function setDeliveryTime(time) {
            document.getElementById('deliveryTime').value = time;
            applyFilters();
        }

        function applyFilters() {
            document.getElementById('filterForm').submit();
        }

        function applySorting(sortBy) {
            const url = new URL(window.location.href);
            if (sortBy !== 'recommended') {
                url.searchParams.set('sort', sortBy);
            } else {
                url.searchParams.delete('sort');
            }
            window.location.href = url.toString();
        }

        function removeFilter(type, value) {
            const url = new URL(window.location.href);

            if (type === 'categories') {
                const categories = new URLSearchParams(url.search).getAll('categories[]');
                const newCategories = categories.filter(cat => cat !== value);
                url.searchParams.delete('categories[]');
                newCategories.forEach(cat => url.searchParams.append('categories[]', cat));
            } else if (type === 'search' || type === 'category') {
                // Clear search from both input and URL
                url.searchParams.delete(type);
                document.getElementById('mainSearchInput').value = '';
            } else {
                url.searchParams.delete(type);
            }

            window.location.href = url.toString();
        }

        function clearAllFilters() {
            const url = new URL(window.location.href);

            // Remove all filter parameters
            const paramsToRemove = [
                'search', 'category', 'categories[]', 'min_rating',
                'delivery_time', 'price_range', 'vegetarian',
                'vegan', 'halal', 'sort'
            ];

            paramsToRemove.forEach(param => {
                url.searchParams.delete(param);
            });

            // Clear search input
            document.getElementById('mainSearchInput').value = '';

            window.location.href = url.toString();
        }

        function setViewMode(mode) {
            const grid = document.getElementById('restaurantsGrid');
            if (mode === 'list') {
                grid.className = 'flex flex-col gap-4';
                grid.querySelectorAll('.restaurant-card').forEach(card => {
                    card.classList.add('flex', 'items-start');
                    const imageDiv = card.querySelector('.card-image');
                    imageDiv.classList.add('w-48', 'h-48', 'flex-shrink-0');
                    imageDiv.parentElement.classList.add('flex-shrink-0');
                });
            } else {
                grid.className = 'grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6';
                grid.querySelectorAll('.restaurant-card').forEach(card => {
                    card.classList.remove('flex', 'items-start');
                    const imageDiv = card.querySelector('.card-image');
                    imageDiv.classList.remove('w-48', 'h-48', 'flex-shrink-0');
                    imageDiv.parentElement.classList.remove('flex-shrink-0');
                });
            }
        }

        function toggleFavorite(button, restaurantId) {
            const icon = button.querySelector('i');
            if (icon.classList.contains('bx-heart')) {
                icon.classList.remove('bx-heart');
                icon.classList.add('bxs-heart');
                icon.style.color = '#ef4444';
                showToast('Added to favorites', 'success');
            } else {
                icon.classList.remove('bxs-heart');
                icon.classList.add('bx-heart');
                icon.style.color = '';
                showToast('Removed from favorites', 'info');
            }
        }

        function showToast(message, type = 'info') {
            // Remove existing toasts
            const existingToasts = document.querySelectorAll('.custom-toast');
            existingToasts.forEach(toast => toast.remove());

            // Create toast element
            const toast = document.createElement('div');
            const typeClass = type === 'info' ? 'bg-blue-50 border border-blue-200 text-blue-800' :
                            type === 'success' ? 'bg-green-50 border border-green-200 text-green-800' :
                            type === 'error' ? 'bg-red-50 border border-red-200 text-red-800' :
                            'bg-yellow-50 border border-yellow-200 text-yellow-800';

            toast.className = `custom-toast ${typeClass}`;

            const icons = {
                info: 'bx bx-info-circle',
                success: 'bx bx-check-circle',
                error: 'bx bx-error-circle',
                warning: 'bx bx-error'
            };

            toast.innerHTML = `
                <i class='${icons[type] || icons.info} text-xl'></i>
                <span>${message}</span>
                <button onclick="this.parentElement.remove()" class="ml-4">
                    <i class='bx bx-x text-xl'></i>
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

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Update filter count
            updateFilterCount();

            // Add focus effect to search input
            const searchInput = document.getElementById('mainSearchInput');
            const searchWrapper = document.getElementById('searchWrapper');

            if (searchInput && searchWrapper) {
                searchInput.addEventListener('focus', () => {
                    searchWrapper.classList.add('focused');
                });

                searchInput.addEventListener('blur', () => {
                    searchWrapper.classList.remove('focused');
                });
            }

            // Update search UI based on current search
            if (window.location.search.includes('search=') || window.location.search.includes('category=')) {
                document.getElementById('mainSearchInput').focus();
            }

            // Initialize carousel scroll buttons
            initCarouselScroll();
        });

        function updateFilterCount() {
            let count = 0;

            // Count category filters
            const categoryInputs = document.querySelectorAll('input[name="categories[]"]:checked');
            count += categoryInputs.length;

            // Count rating filter
            if (document.querySelector('input[name="min_rating"]:checked')) {
                count++;
            }

            // Count delivery time filter
            if (document.querySelector('input[name="delivery_time"]').value) {
                count++;
            }

            // Count dietary filters
            if (document.querySelector('input[name="vegetarian"]:checked') ||
                document.querySelector('input[name="vegan"]:checked') ||
                document.querySelector('input[name="halal"]:checked')) {
                count++;
            }

            document.getElementById('filter-count').textContent = count;
        }

        function initCarouselScroll() {
            // Add scroll buttons for carousels
            const carousels = document.querySelectorAll('.restaurant-carousel');

            carousels.forEach(carousel => {
                // Add navigation buttons if needed
                const container = carousel.parentElement;

                // Check if content overflows
                if (carousel.scrollWidth > carousel.clientWidth) {
                    const prevBtn = document.createElement('button');
                    const nextBtn = document.createElement('button');

                    prevBtn.innerHTML = '<i class="bx bx-chevron-left"></i>';
                    nextBtn.innerHTML = '<i class="bx bx-chevron-right"></i>';

                    prevBtn.className = 'absolute left-0 top-1/2 transform -translate-y-1/2 bg-white shadow-lg rounded-full w-8 h-8 flex items-center justify-center text-gray-600 hover:text-primary-600 z-10';
                    nextBtn.className = 'absolute right-0 top-1/2 transform -translate-y-1/2 bg-white shadow-lg rounded-full w-8 h-8 flex items-center justify-center text-gray-600 hover:text-primary-600 z-10';

                    prevBtn.style.left = '-16px';
                    nextBtn.style.right = '-16px';

                    prevBtn.onclick = () => {
                        carousel.scrollBy({ left: -300, behavior: 'smooth' });
                    };

                    nextBtn.onclick = () => {
                        carousel.scrollBy({ left: 300, behavior: 'smooth' });
                    };

                    container.style.position = 'relative';
                    container.appendChild(prevBtn);
                    container.appendChild(nextBtn);
                }
            });
        }
    </script>
</body>
</html>
