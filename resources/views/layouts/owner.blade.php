<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Owner Dashboard' }} - FoodOrder</title>

    <!-- Poppins Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Box Icons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Custom Tailwind Config -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'poppins': ['Poppins', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#f0fdf4',
                            100: '#dcfce7',
                            200: '#bbf7d0',
                            300: '#86efac',
                            400: '#4ade80',
                            500: '#22c55e',
                            600: '#16a34a',
                            700: '#15803d',
                            800: '#166534',
                            900: '#14532d',
                        },
                        accent: {
                            orange: '#fb923c',
                            blue: '#3b82f6',
                            purple: '#8b5cf6',
                            amber: '#f59e0b'
                        }
                    }
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .stat-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }

        .sidebar-item {
            transition: all 0.2s ease;
        }

        .sidebar-item:hover {
            background: #fef7ed;
            color: #d97706;
        }

        .sidebar-item.active {
            background: #fffbeb;
            color: #d97706;
            border-right: 3px solid #f59e0b;
        }

        .order-badge {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }

        .tooltip {
            position: relative;
        }

        .tooltip:hover::after {
            content: attr(title);
            position: absolute;
            bottom: -30px;
            left: 50%;
            transform: translateX(-50%);
            background: #333;
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            white-space: nowrap;
            z-index: 1000;
        }
    </style>
</head>
<body class="font-poppins bg-gray-50 min-h-screen">
    <div class="flex">
        <!-- Sidebar -->
        <div class="w-64 bg-white h-screen sticky top-0 shadow-lg">
            <!-- Logo -->
            <div class="p-6 border-b border-gray-100">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-accent-amber rounded-xl flex items-center justify-center">
                        <i class='bx bx-store text-2xl text-white'></i>
                    </div>
                    <div>
                        <h1 class="text-gray-900 font-bold text-xl">FoodOrder</h1>
                        <p class="text-gray-500 text-xs">Restaurant Owner</p>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="p-4 space-y-1">
                <a href="{{ route('owner.dashboard') }}"
                class="sidebar-item flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('owner.dashboard') ? 'active' : 'text-gray-600' }}">
                    <i class='bx bx-home-alt-2 text-xl'></i>
                    <span class="font-medium">Dashboard</span>
                </a>

                @auth
                    @if(auth()->user()->hasRestaurant())
                        @php
                            // ✅ DATA REAL: Hitung pending orders
                            $pendingOrdersCount = \App\Models\Order::where('restaurant_id', auth()->user()->restaurant->id)
                                ->whereIn('status', ['pending', 'confirmed', 'preparing', 'ready'])
                                ->where('status', '!=', 'completed')
                                ->where('status', '!=', 'cancelled')
                                ->count();

                            // ✅ DATA REAL: Hitung menu items
                            $menuItemsCount = \App\Models\MenuItem::where('restaurant_id', auth()->user()->restaurant->id)->count();
                        @endphp

                        <a href="{{ route('owner.orders.index') }}"
                        class="sidebar-item flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('owner.orders*') ? 'active' : 'text-gray-600' }}">
                            <i class='bx bx-receipt text-xl'></i>
                            <span class="font-medium">Orders</span>
                            @if($pendingOrdersCount > 0)
                            <span class="ml-auto bg-orange-100 text-orange-800 text-xs px-2 py-1 rounded-full order-badge">
                                {{ $pendingOrdersCount }}
                            </span>
                            @endif
                        </a>

                        <a href="{{ route('owner.menu-items.index') }}"
                        class="sidebar-item flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('owner.menu-items*') ? 'active' : 'text-gray-600' }}">
                            <i class='bx bx-food-menu text-xl'></i>
                            <span class="font-medium">Menu Items</span>
                            <span class="ml-auto bg-primary-100 text-primary-800 text-xs px-2 py-1 rounded-full">
                                {{ $menuItemsCount }}
                            </span>
                        </a>

                        <a href="{{ route('owner.analytics.index') }}"
                        class="sidebar-item flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('owner.analytics*') ? 'active' : 'text-gray-600' }}">
                            <i class='bx bx-bar-chart-alt text-xl'></i>
                            <span class="font-medium">Analytics</span>
                        </a>

                        <a href="{{ route('owner.restaurants.edit') }}"
                        class="sidebar-item flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('owner.restaurants*') ? 'active' : 'text-gray-600' }}">
                            <i class='bx bx-cog text-xl'></i>
                            <span class="font-medium">Restaurant Settings</span>
                        </a>
                    @else
                        <a href="{{ route('owner.restaurants.create') }}"
                        class="sidebar-item flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('owner.restaurants.create') ? 'active' : 'text-gray-600' }}">
                            <i class='bx bx-plus text-xl'></i>
                            <span class="font-medium">Create Restaurant</span>
                            <span class="ml-auto bg-orange-100 text-orange-800 text-xs px-2 py-1 rounded-full order-badge">New</span>
                        </a>
                    @endif
                @endauth
            </nav>

            <!-- Restaurant Info -->
            <div class="absolute bottom-20 left-0 right-0 p-4 border-t border-gray-100">
                <div class="bg-amber-50 border border-amber-200 rounded-xl p-3">
                    <div class="flex items-center space-x-2 mb-2">
                        <i class='bx bx-store text-amber-600'></i>
                        <span class="font-semibold text-amber-900 text-sm">My Restaurant</span>
                    </div>

                    @auth
                        @if(auth()->user()->hasRestaurant())
                            @php
                                $restaurant = auth()->user()->restaurant;
                            // ✅ DATA REAL: Hitung today's revenue
                                $todayRevenue = \App\Models\Order::where('restaurant_id', $restaurant->id)
                                    ->where('status', 'completed')
                                    ->whereDate('created_at', today())
                                    ->sum('total_amount');
                            @endphp
                            <p class="text-amber-800 text-sm font-medium truncate">{{ $restaurant->name }}</p>
                            <p class="text-amber-600 text-xs">Status:
                                <span class="capitalize {{ $restaurant->status === 'active' ? 'text-green-600' : 'text-gray-600' }} font-medium">
                                    {{ $restaurant->status }}
                                </span>
                                @if($todayRevenue > 0)
                                • <span class="text-green-600 font-medium">Rp {{ number_format($todayRevenue, 0, ',', '.') }}</span>
                                @endif
                            </p>
                        @else
                            <p class="text-amber-800 text-sm font-medium">No Restaurant</p>
                            <p class="text-amber-600 text-xs">Status: <span class="text-gray-600 font-medium">Not Setup</span></p>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- User Profile -->
            <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-gray-100">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-r from-accent-amber to-orange-500 rounded-full flex items-center justify-center">
                        <span class="text-white font-semibold text-sm">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </span>
                    </div>
                    <div class="flex-1">
                        <p class="font-semibold text-sm text-gray-900">{{ auth()->user()->name }}</p>
                        <p class="text-gray-500 text-xs">Restaurant Owner</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-gray-400 hover:text-gray-600 transition">
                            <i class='bx bx-log-out text-xl'></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Top Bar -->
            <header class="bg-white shadow-sm border-b border-gray-100">
                <div class="flex items-center justify-between p-4">
                    <!-- Page Title -->
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">@yield('title', 'Dashboard')</h1>
                        <p class="text-gray-600">Manage your restaurant efficiently</p>
                    </div>

                    <!-- Right Section -->
                    <div class="flex items-center space-x-4">
                        <!-- Quick Stats -->
                        @auth
                            @if(auth()->user()->hasRestaurant())
                                @php
                                    $restaurant = auth()->user()->restaurant;

                                    // ✅ DATA REAL: Today's Revenue
                                    $todayRevenue = \App\Models\Order::where('restaurant_id', $restaurant->id)
                                        ->where('status', 'completed')
                                        ->whereDate('created_at', today())
                                        ->sum('total_amount');

                                    // ✅ DATA REAL: Active Orders (pending, confirmed, preparing, ready)
                                    $activeOrdersCount = \App\Models\Order::where('restaurant_id', $restaurant->id)
                                        ->whereIn('status', ['pending', 'confirmed', 'preparing', 'ready'])
                                        ->count();

                                    // ✅ DATA REAL: Pending notifications (orders yang butuh perhatian)
                                    $pendingNotifications = \App\Models\Order::where('restaurant_id', $restaurant->id)
                                        ->whereIn('status', ['pending', 'confirmed'])
                                        ->count();
                                @endphp

                                <div class="flex items-center space-x-6">
                                    <div class="text-center">
                                        <p class="text-sm text-gray-600">Today's Revenue</p>
                                        <p class="font-semibold text-green-600">
                                            Rp {{ number_format($todayRevenue, 0, ',', '.') }}
                                        </p>
                                    </div>
                                    <div class="text-center">
                                        <p class="text-sm text-gray-600">Active Orders</p>
                                        <p class="font-semibold text-orange-600">{{ $activeOrdersCount }}</p>
                                    </div>
                                </div>

                                <!-- Notifications -->
                                <button class="relative p-2 text-gray-400 hover:text-gray-600 transition tooltip" title="{{ $pendingNotifications }} pending orders need attention">
                                    <i class='bx bx-bell text-xl'></i>
                                    @if($pendingNotifications > 0)
                                    <span class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 rounded-full text-xs flex items-center justify-center text-white">
                                        {{ $pendingNotifications }}
                                    </span>
                                    @endif
                                </button>
                            @else
                                <!-- Default stats ketika belum punya restaurant -->
                                <div class="flex items-center space-x-6">
                                    <div class="text-center">
                                        <p class="text-sm text-gray-600">Today's Revenue</p>
                                        <p class="font-semibold text-gray-400">Rp 0</p>
                                    </div>
                                    <div class="text-center">
                                        <p class="text-sm text-gray-600">Active Orders</p>
                                        <p class="font-semibold text-gray-400">0</p>
                                    </div>
                                </div>

                                <button class="relative p-2 text-gray-400 hover:text-gray-600 transition">
                                    <i class='bx bx-bell text-xl'></i>
                                </button>
                            @endif
                        @endauth
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 p-6">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Alpine JS untuk interactivity -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <!-- Auto-refresh untuk real-time data -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-refresh data setiap 30 detik
            setInterval(() => {
                // Refresh page untuk update data real-time
                // Bisa diganti dengan AJAX call nanti
                window.location.reload();
            }, 30000); // 30 detik

            // Tooltip initialization
            const tooltips = document.querySelectorAll('.tooltip');
            tooltips.forEach(tooltip => {
                tooltip.addEventListener('mouseenter', function() {
                    // Tooltip sudah dihandle oleh CSS
                });
            });
        });
    </script>
</body>
</html>
