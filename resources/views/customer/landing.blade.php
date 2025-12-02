<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodOrder - Order Makanan Online Terbaik</title>

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

        .hero-bg {
            background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
        }

        .feature-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .feature-card:hover {
            transform: translateY(-5px);
        }

        .restaurant-card {
            transition: transform 0.2s ease;
        }

        .restaurant-card:hover {
            transform: scale(1.05);
        }
    </style>
</head>
<body class="font-poppins bg-white">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm border-b border-gray-100 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-primary-500 rounded-xl flex items-center justify-center">
                        <i class='bx bx-restaurant text-2xl text-white'></i>
                    </div>
                    <div class="ml-3">
                        <h1 class="text-xl font-bold text-gray-900">FoodOrder</h1>
                    </div>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#" class="text-gray-600 hover:text-primary-600 font-medium">Home</a>
                    <a href="#" class="text-gray-600 hover:text-primary-600 font-medium">Restaurants</a>
                    <a href="#" class="text-gray-600 hover:text-primary-600 font-medium">How It Works</a>
                    <a href="#" class="text-gray-600 hover:text-primary-600 font-medium">About Us</a>
                </div>

                <!-- Auth Buttons -->
                <div class="flex items-center space-x-4">
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-primary-600 font-medium">Login</a>
                    <a href="{{ route('register') }}" class="bg-primary-500 hover:bg-primary-600 text-white px-6 py-2 rounded-lg font-medium transition">
                        Sign Up
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-bg text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h1 class="text-4xl md:text-6xl font-bold mb-6 leading-tight">
                        Order Food
                        <span class="text-yellow-300">You Love</span>
                    </h1>
                    <p class="text-xl text-green-100 mb-8 leading-relaxed">
                        Discover the best restaurants in your area and get your favorite food delivered to your doorstep in minutes.
                    </p>

                    <!-- Search Bar -->
                    <div class="bg-white rounded-2xl p-2 shadow-lg max-w-2xl">
                        <div class="flex">
                            <div class="flex-1 flex items-center px-4">
                                <i class='bx bx-map text-gray-400 text-xl mr-3'></i>
                                <input type="text" placeholder="Enter your delivery address..."
                                       class="w-full py-3 text-gray-700 placeholder-gray-400 focus:outline-none">
                            </div>
                            <button class="bg-primary-500 hover:bg-primary-600 text-white px-8 py-3 rounded-xl font-semibold transition">
                                Find Food
                            </button>
                        </div>
                    </div>

                    <!-- Stats -->
                    <div class="flex items-center space-x-8 mt-8">
                        <div class="text-center">
                            <p class="text-2xl font-bold">200+</p>
                            <p class="text-green-100 text-sm">Restaurants</p>
                        </div>
                        <div class="text-center">
                            <p class="text-2xl font-bold">10K+</p>
                            <p class="text-green-100 text-sm">Happy Customers</p>
                        </div>
                        <div class="text-center">
                            <p class="text-2xl font-bold">15-30</p>
                            <p class="text-green-100 text-sm">Min Delivery</p>
                        </div>
                    </div>
                </div>

                <div class="hidden lg:block">
                    <img src="https://cdn-icons-png.flaticon.com/512/5787/5787016.png" alt="Food Delivery" class="w-full h-auto">
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Why Choose FoodOrder?</h2>
                <p class="text-gray-600 text-lg">We make food ordering simple and delightful</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="feature-card bg-white rounded-2xl p-8 text-center shadow-sm border border-gray-100">
                    <div class="w-16 h-16 bg-primary-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <i class='bx bx-bolt text-3xl text-primary-600'></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Fast Delivery</h3>
                    <p class="text-gray-600">Get your food delivered in 20-30 minutes with our optimized delivery network</p>
                </div>

                <div class="feature-card bg-white rounded-2xl p-8 text-center shadow-sm border border-gray-100">
                    <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <i class='bx bx-shield-alt text-3xl text-blue-600'></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Safe & Secure</h3>
                    <p class="text-gray-600">Your payments and data are protected with industry-standard security</p>
                </div>

                <div class="feature-card bg-white rounded-2xl p-8 text-center shadow-sm border border-gray-100">
                    <div class="w-16 h-16 bg-purple-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <i class='bx bx-star text-3xl text-purple-600'></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Best Quality</h3>
                    <p class="text-gray-600">We partner with the best restaurants to ensure food quality and taste</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Popular Restaurants Preview -->
    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Popular Restaurants</h2>
                <p class="text-gray-600 text-lg">Discover amazing food from top-rated restaurants</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-8">
                @foreach([
                    ['name' => 'Warung Enak', 'emoji' => '🍛', 'category' => 'Indonesian'],
                    ['name' => 'Burger Kingdom', 'emoji' => '🍔', 'category' => 'Western'],
                    ['name' => 'Sushi Master', 'emoji' => '🍣', 'category' => 'Japanese'],
                    ['name' => 'Sweet Dreams', 'emoji' => '🍰', 'category' => 'Desserts']
                ] as $restaurant)
                <div class="restaurant-card bg-white rounded-2xl p-6 text-center shadow-sm border border-gray-100 cursor-pointer">
                    <div class="w-20 h-20 bg-primary-50 rounded-2xl flex items-center justify-center text-3xl mx-auto mb-4">
                        {{ $restaurant['emoji'] }}
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-1">{{ $restaurant['name'] }}</h3>
                    <p class="text-gray-600 text-sm">{{ $restaurant['category'] }}</p>
                </div>
                @endforeach
            </div>

            <div class="text-center">
                <a href="{{ route('register') }}" class="bg-primary-500 hover:bg-primary-600 text-white px-8 py-4 rounded-xl font-semibold text-lg transition inline-block">
                    Explore All Restaurants
                </a>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-gradient-to-r from-accent-orange to-accent-amber">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white">
            <h2 class="text-3xl font-bold mb-4">Ready to Order Your Favorite Food?</h2>
            <p class="text-orange-100 text-xl mb-8">Join thousands of satisfied customers today</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('register') }}" class="bg-white text-orange-600 px-8 py-4 rounded-xl font-semibold text-lg hover:bg-orange-50 transition">
                    Get Started Free
                </a>
                <a href="{{ route('login') }}" class="border-2 border-white text-white px-8 py-4 rounded-xl font-semibold text-lg hover:bg-white hover:text-orange-600 transition">
                    Sign In
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 bg-primary-500 rounded-xl flex items-center justify-center">
                            <i class='bx bx-restaurant text-2xl text-white'></i>
                        </div>
                        <div class="ml-3">
                            <h1 class="text-xl font-bold">FoodOrder</h1>
                        </div>
                    </div>
                    <p class="text-gray-400">Delivering happiness to your doorstep</p>
                </div>

                <div>
                    <h3 class="font-semibold mb-4">Company</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white transition">About Us</a></li>
                        <li><a href="#" class="hover:text-white transition">Careers</a></li>
                        <li><a href="#" class="hover:text-white transition">Contact</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="font-semibold mb-4">Support</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white transition">Help Center</a></li>
                        <li><a href="#" class="hover:text-white transition">Privacy Policy</a></li>
                        <li><a href="#" class="hover:text-white transition">Terms of Service</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="font-semibold mb-4">Download App</h3>
                    <div class="space-y-3">
                        <button class="w-full bg-gray-800 hover:bg-gray-700 text-white py-3 px-4 rounded-lg transition flex items-center justify-center space-x-2">
                            <i class='bx bxl-play-store text-xl'></i>
                            <span>Google Play</span>
                        </button>
                        <button class="w-full bg-gray-800 hover:bg-gray-700 text-white py-3 px-4 rounded-lg transition flex items-center justify-center space-x-2">
                            <i class='bx bxl-apple text-xl'></i>
                            <span>App Store</span>
                        </button>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; 2024 FoodOrder. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Alpine JS -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</body>
</html>
