<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin Dashboard' }} - FoodOrder</title>

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
                            pink: '#ec4899'
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
            background: #f0fdf4;
            color: #16a34a;
        }

        .sidebar-item.active {
            background: #dcfce7;
            color: #15803d;
            border-right: 3px solid #22c55e;
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
                    <div class="w-10 h-10 bg-primary-500 rounded-xl flex items-center justify-center">
                        <i class='bx bx-restaurant text-2xl text-white'></i>
                    </div>
                    <div>
                        <h1 class="text-gray-900 font-bold text-xl">FoodOrder</h1>
                        <p class="text-gray-500 text-xs">Admin Panel</p>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="p-4 space-y-1">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-item flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'active' : 'text-gray-600' }}">
                    <i class='bx bx-home-alt-2 text-xl'></i>
                    <span class="font-medium">Dashboard</span>
                </a>

                <a href="{{ route('admin.users') }}" class="sidebar-item flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('admin.users*') ? 'active' : 'text-gray-600' }}">
                    <i class='bx bx-user text-xl'></i>
                    <span class="font-medium">User Management</span>
                    <span class="ml-auto bg-primary-100 text-primary-800 text-xs px-2 py-1 rounded-full">{{ App\Models\User::count() }}</span>
                </a>

                <a href="{{ route('admin.restaurants') }}" class="sidebar-item flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('admin.restaurants*') ? 'active' : 'text-gray-600' }}">
                    <i class='bx bx-store-alt text-xl'></i>
                    <span class="font-medium">Restaurants</span>
                    <span class="ml-auto bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">{{ App\Models\Restaurant::count() }}</span>
                </a>

                <a href="{{ route('admin.orders') }}" class="sidebar-item flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('admin.orders*') ? 'active' : 'text-gray-600' }}">
                    <i class='bx bx-receipt text-xl'></i>
                    <span class="font-medium">Orders</span>
                    <span class="ml-auto bg-orange-100 text-orange-800 text-xs px-2 py-1 rounded-full">156</span>
                </a>

                {{-- <a href="{{ route('admin.analytics') }}" class="sidebar-item flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('admin.analytics*') ? 'active' : 'text-gray-600' }}">
                    <i class='bx bx-bar-chart-alt text-xl'></i>
                    <span class="font-medium">Analytics</span>
                </a>

                <a href="{{ route('admin.settings') }}" class="sidebar-item flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('admin.settings*') ? 'active' : 'text-gray-600' }}">
                    <i class='bx bx-cog text-xl'></i>
                    <span class="font-medium">Settings</span>
                </a> --}}
            </nav>

            <!-- User Profile -->
            <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-gray-100">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-r from-primary-500 to-primary-600 rounded-full flex items-center justify-center">
                        <span class="text-white font-semibold text-sm">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </span>
                    </div>
                    <div class="flex-1">
                        <p class="font-semibold text-sm text-gray-900">{{ auth()->user()->name }}</p>
                        <p class="text-gray-500 text-xs">Administrator</p>
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
                        <p class="text-gray-600">Welcome back, {{ auth()->user()->name }}</p>
                    </div>

                    <!-- Right Section -->
                    <div class="flex items-center space-x-4">
                        <!-- Search -->
                        <div class="relative">
                            <i class='bx bx-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400'></i>
                            <input type="text" placeholder="Search..." class="pl-10 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-xl text-gray-700 placeholder-gray-400 focus:outline-none focus:border-primary-300 focus:ring-1 focus:ring-primary-300 w-64">
                        </div>

                        <!-- Notifications -->
                        <button class="relative p-2 text-gray-400 hover:text-gray-600 transition">
                            <i class='bx bx-bell text-xl'></i>
                            <span class="absolute -top-1 -right-1 w-4 h-4 bg-accent-orange rounded-full text-xs flex items-center justify-center text-white">3</span>
                        </button>
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
</body>
</html>
