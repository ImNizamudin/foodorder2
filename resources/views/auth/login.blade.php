<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - FoodOrder</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Box Icons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

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
                        }
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'float-delayed': 'float 6s ease-in-out infinite 1.5s',
                        'fade-in': 'fadeIn 0.5s ease-out',
                        'slide-up': 'slideUp 0.8s ease-out',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0px) rotate(0deg)' },
                            '50%': { transform: 'translateY(-20px) rotate(2deg)' },
                        },
                        fadeIn: {
                            '0%': { opacity: '0', transform: 'translateY(10px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                        slideUp: {
                            '0%': { opacity: '0', transform: 'translateY(30px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        }
                    }
                }
            }
        }
    </script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
        }

        .login-container {
            min-height: 100vh;
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
        }

        .auth-card {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(10px);
        }

        .input-group:focus-within {
            transform: translateY(-2px);
            transition: transform 0.3s ease;
        }

        .btn-primary {
            background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #16a34a 0%, #15803d 100%);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(34, 197, 94, 0.4);
        }

        .loading-spinner {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .notification {
            animation: slideDown 0.3s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Error styling */
        .input-error {
            border-color: #ef4444 !important;
        }

        .error-message {
            color: #ef4444;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
    </style>
</head>
<body class="login-container font-poppins">
    <div class="min-h-screen flex">
        <!-- Left Side - Login Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-4 lg:p-8">
            <div class="auth-card w-full max-w-md rounded-2xl p-6 lg:p-8 shadow-xl animate-fade-in">
                <!-- Logo -->
                <div class="flex items-center justify-center mb-6">
                    <div class="w-12 h-12 bg-gradient-to-br from-primary-500 to-primary-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class='bx bx-restaurant text-2xl text-white'></i>
                    </div>
                    <div class="ml-4">
                        <h1 class="text-2xl font-bold text-gray-900">FoodOrder</h1>
                        <p class="text-sm text-gray-600">Delicious food, delivered fast</p>
                    </div>
                </div>

                <!-- Welcome Message -->
                <div class="text-center mb-6">
                    <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 mb-3">Welcome Back!</h1>
                    <p class="text-gray-600 text-sm lg:text-base">Simplify your workflow and boost your productivity with FoodOrder</p>
                </div>

                <!-- Login Form - Traditional Laravel Form -->
                <form method="POST" action="{{ route('login') }}" id="loginForm" class="space-y-5">
                    @csrf

                    <!-- Email Input -->
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-gray-700">Email Address</label>
                        <div class="input-group">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class='bx bx-envelope text-gray-400 text-xl'></i>
                                </div>
                                <input type="email"
                                       id="email"
                                       name="email"
                                       value="{{ old('email') }}"
                                       class="w-full pl-12 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition placeholder-gray-400 text-sm lg:text-base @error('email') input-error @enderror"
                                       placeholder="Enter your email"
                                       required
                                       autocomplete="email"
                                       autofocus>
                            </div>
                            @error('email')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Password Input -->
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-gray-700">Password</label>
                        <div class="input-group">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class='bx bx-lock-alt text-gray-400 text-xl'></i>
                                </div>
                                <input type="password"
                                       id="password"
                                       name="password"
                                       class="w-full pl-12 pr-12 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition placeholder-gray-400 text-sm lg:text-base @error('password') input-error @enderror"
                                       placeholder="Enter your password"
                                       required
                                       autocomplete="current-password">
                                <button type="button"
                                        onclick="togglePassword('password')"
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 transition">
                                    <i class='bx bx-hide' id="password-toggle-icon"></i>
                                </button>
                            </div>
                            @error('password')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between">
                        <label class="flex items-center space-x-2 cursor-pointer">
                            <input type="checkbox"
                                   id="remember"
                                   name="remember"
                                   {{ old('remember') ? 'checked' : '' }}
                                   class="w-4 h-4 text-primary-500 bg-white border-gray-300 rounded focus:ring-primary-500">
                            <span class="text-gray-700 text-sm">Remember me</span>
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-primary-500 hover:text-primary-600 text-sm font-medium transition">
                                Forgot Password?
                            </a>
                        @endif
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                            id="login-btn"
                            class="w-full btn-primary text-white py-3 rounded-xl font-semibold transition flex items-center justify-center space-x-2 shadow-lg hover:shadow-xl text-sm lg:text-base">
                        <i class='bx bx-loader-circle bx-spin hidden' id="login-spinner"></i>
                        <span id="login-text">Login</span>
                    </button>
                </form>

                <!-- Register Link -->
                <div class="text-center mt-6 pt-5 border-t border-gray-100">
                    <p class="text-gray-600 text-sm">
                        Not a member?
                        <a href="{{ route('register') }}" class="text-primary-500 hover:text-primary-600 font-semibold transition ml-1">
                            Register now
                        </a>
                    </p>
                </div>

                <!-- Copyright -->
                <div class="text-center mt-6">
                    <p class="text-xs text-gray-500">&copy; 2024 FoodOrder. All rights reserved.</p>
                </div>
            </div>
        </div>

        <!-- Right Side - Illustrations -->
        <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-primary-500 via-primary-400 to-primary-600 items-center justify-center p-8 lg:p-12 relative overflow-hidden">
            <!-- Background Pattern -->
            <div class="absolute inset-0 opacity-5">
                <div class="absolute top-0 left-0 w-64 h-64 bg-white rounded-full -translate-x-1/2 -translate-y-1/2"></div>
                <div class="absolute bottom-0 right-0 w-96 h-96 bg-white rounded-full translate-x-1/2 translate-y-1/2"></div>
                <div class="absolute top-1/2 left-1/2 w-48 h-48 bg-white rounded-full -translate-x-1/2 -translate-y-1/2"></div>
            </div>

            <!-- Illustrations Container -->
            <div class="relative z-10 w-full max-w-3xl animate-slide-up">
                <!-- Heading for Illustrations -->
                <div class="text-center mb-10">
                    <h2 class="text-3xl font-bold text-white mb-4">Make Your Work Easier</h2>
                    <p class="text-lg text-white opacity-90">Organize and manage your food orders with our intuitive platform</p>
                </div>

                <!-- Two Illustrations Side by Side -->
                <div class="flex flex-col lg:flex-row items-center justify-center gap-8 mb-10">
                    <!-- First Illustration - Breakfast -->
                    <div class="flex-1 flex flex-col items-center">
                        <div class="mb-8 text-center animate-float">
                            <div class="relative w-48 h-48 lg:w-56 lg:h-56 mx-auto mb-4">
                                <img src="{{ asset('assets/breakfast.svg') }}"
                                     alt="Breakfast Illustration"
                                     class="w-full h-full object-contain">
                                <!-- Floating decorative circles -->
                                <div class="absolute -top-2 -right-2 w-8 h-8 bg-yellow-300 rounded-full opacity-70 animate-pulse"></div>
                                <div class="absolute -bottom-3 -left-3 w-10 h-10 bg-orange-300 rounded-full opacity-60 animate-pulse" style="animation-delay: 0.3s"></div>
                            </div>
                            <p class="text-white font-medium text-lg">Delicious Breakfast</p>
                            <p class="text-white opacity-80 text-sm mt-1">Start your day right with our breakfast options</p>
                        </div>
                    </div>

                    <!-- Second Illustration - Pancakes -->
                    <div class="flex-1 flex flex-col items-center">
                        <div class="mb-8 text-center animate-float-delayed">
                            <div class="relative w-48 h-48 lg:w-56 lg:h-56 mx-auto mb-4">
                                <img src="{{ asset('assets/pancakes.svg') }}"
                                     alt="Pancakes Illustration"
                                     class="w-full h-full object-contain">
                                <!-- Floating decorative circles -->
                                <div class="absolute -top-3 -left-3 w-10 h-10 bg-red-300 rounded-full opacity-70 animate-pulse" style="animation-delay: 0.2s"></div>
                                <div class="absolute -bottom-2 -right-2 w-8 h-8 bg-amber-300 rounded-full opacity-60 animate-pulse" style="animation-delay: 0.5s"></div>
                            </div>
                            <p class="text-white font-medium text-lg">Tasty Pancakes</p>
                            <p class="text-white opacity-80 text-sm mt-1">Enjoy fluffy pancakes made to perfection</p>
                        </div>
                    </div>
                </div>

                <!-- Features List -->
                <div class="grid grid-cols-3 gap-4 lg:gap-6 mt-8 px-4">
                    <div class="text-center group cursor-pointer">
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center mx-auto mb-3 transition-all duration-300 group-hover:bg-opacity-30 group-hover:scale-110">
                            <i class='bx bx-time-five text-2xl text-white'></i>
                        </div>
                        <p class="text-sm font-medium text-white">Fast Delivery</p>
                        <p class="text-xs text-white opacity-80 mt-1">15-30 min</p>
                    </div>

                    <div class="text-center group cursor-pointer">
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center mx-auto mb-3 transition-all duration-300 group-hover:bg-opacity-30 group-hover:scale-110">
                            <i class='bx bx-shield-alt text-2xl text-white'></i>
                        </div>
                        <p class="text-sm font-medium text-white">Secure</p>
                        <p class="text-xs text-white opacity-80 mt-1">Safe payments</p>
                    </div>

                    <div class="text-center group cursor-pointer">
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center mx-auto mb-3 transition-all duration-300 group-hover:bg-opacity-30 group-hover:scale-110">
                            <i class='bx bx-star text-2xl text-white'></i>
                        </div>
                        <p class="text-sm font-medium text-white">Quality</p>
                        <p class="text-xs text-white opacity-80 mt-1">Top restaurants</p>
                    </div>
                </div>

                <!-- Decorative Quote -->
                <div class="text-center mt-10 pt-8 border-t border-white border-opacity-20">
                    <p class="text-white italic opacity-90">"Good food is the foundation of genuine happiness"</p>
                    <p class="text-white text-sm opacity-70 mt-2">- Auguste Escoffier</p>
                </div>
            </div>

            <!-- Floating Elements -->
            <div class="absolute top-1/4 left-10 w-6 h-6 bg-white bg-opacity-30 rounded-full animate-pulse"></div>
            <div class="absolute bottom-1/4 right-10 w-8 h-8 bg-white bg-opacity-30 rounded-full animate-pulse" style="animation-delay: 0.5s"></div>
            <div class="absolute top-3/4 left-1/4 w-4 h-4 bg-white bg-opacity-30 rounded-full animate-pulse" style="animation-delay: 1s"></div>
        </div>
    </div>

    <!-- Notification Toast (untuk success message dari session) -->
    @if(session('success'))
        <div id="notification" class="fixed top-4 right-4 p-4 rounded-xl text-white font-medium z-50 shadow-lg max-w-sm notification bg-primary-500">
            <div class="flex items-center space-x-2">
                <i class='bx bx-check-circle'></i>
                <span>{{ session('success') }}</span>
            </div>
        </div>

        <script>
            setTimeout(() => {
                document.getElementById('notification').classList.add('hidden');
            }, 5000);
        </script>
    @endif

    @if(session('error'))
        <div id="notification" class="fixed top-4 right-4 p-4 rounded-xl text-white font-medium z-50 shadow-lg max-w-sm notification bg-red-500">
            <div class="flex items-center space-x-2">
                <i class='bx bx-error'></i>
                <span>{{ session('error') }}</span>
            </div>
        </div>

        <script>
            setTimeout(() => {
                document.getElementById('notification').classList.add('hidden');
            }, 5000);
        </script>
    @endif

    <script>
        // Toggle password visibility
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const icon = document.getElementById('password-toggle-icon');

            if (field.type === 'password') {
                field.type = 'text';
                icon.className = 'bx bx-show';
            } else {
                field.type = 'password';
                icon.className = 'bx bx-hide';
            }
        }

        // Handle form submission untuk show loading state
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const submitBtn = document.getElementById('login-btn');
            const spinner = document.getElementById('login-spinner');
            const loginText = document.getElementById('login-text');

            // Show loading state
            submitBtn.disabled = true;
            spinner.classList.remove('hidden');
            loginText.textContent = 'Signing in...';

            // Form akan tetap submit secara traditional
            // Loading state hanya untuk UI feedback
        });

        // Add focus effects to input groups
        document.querySelectorAll('.input-group input').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.parentElement.style.transform = 'translateY(-2px)';
                // Remove error border on focus
                this.classList.remove('input-error');

                // Remove error message if exists
                const errorMessage = this.parentElement.parentElement.nextElementSibling;
                if (errorMessage && errorMessage.classList.contains('error-message')) {
                    errorMessage.remove();
                }
            });

            input.addEventListener('blur', function() {
                this.parentElement.parentElement.style.transform = 'translateY(0)';
            });
        });

        // Add hover effects to illustrations
        const illustrations = document.querySelectorAll('img[alt*="Illustration"]');
        illustrations.forEach(img => {
            img.addEventListener('mouseenter', function() {
                this.style.transition = 'transform 0.3s ease';
                this.style.transform = 'scale(1.05)';
            });

            img.addEventListener('mouseleave', function() {
                this.style.transform = 'scale(1)';
            });
        });

        // Auto-remove error styling on input
        document.querySelectorAll('input').forEach(input => {
            input.addEventListener('input', function() {
                if (this.classList.contains('input-error')) {
                    this.classList.remove('input-error');

                    // Remove error message if exists
                    const parentGroup = this.closest('.space-y-2');
                    if (parentGroup) {
                        const errorMessage = parentGroup.querySelector('.error-message');
                        if (errorMessage) {
                            errorMessage.remove();
                        }
                    }
                }
            });
        });

        // Auto-focus on email field
        document.addEventListener('DOMContentLoaded', function() {
            const emailField = document.getElementById('email');
            if (emailField && !emailField.value) {
                emailField.focus();
            }
        });
    </script>
</body>
</html>
