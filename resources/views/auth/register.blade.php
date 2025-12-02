<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account - FoodOrder</title>

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
                            '50%': { transform: 'translateY(-15px) rotate(1deg)' },
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

        .register-container {
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

        .btn-secondary {
            background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background: linear-gradient(135deg, #4b5563 0%, #374151 100%);
            transform: translateY(-2px);
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

        .step {
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .step.active {
            background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
            color: white;
            transform: scale(1.1);
            box-shadow: 0 10px 25px -5px rgba(34, 197, 94, 0.4);
        }

        .step.completed {
            background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
            color: white;
            box-shadow: 0 4px 6px -1px rgba(34, 197, 94, 0.2);
        }

        .password-strength {
            transition: all 0.3s ease;
        }

        .step-content {
            display: none;
            animation: fadeIn 0.5s ease-out;
        }

        .step-content.active {
            display: block;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateX(20px); }
            to { opacity: 1; transform: translateX(0); }
        }

        .progress-line {
            background: linear-gradient(to right, #22c55e, #16a34a);
            transition: all 0.3s ease;
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

        /* Hide traditional form submit */
        .hidden-form {
            display: none;
        }
    </style>
</head>
<body class="register-container font-poppins">
    <div class="min-h-screen flex">
        <!-- Left Side - Registration Form -->
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

                <!-- Header -->
                <div class="text-center mb-6">
                    <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 mb-3">Join FoodOrder</h1>
                    <p class="text-gray-600 text-sm lg:text-base">Create your account and start ordering delicious food</p>
                </div>

                <!-- Progress Steps -->
                <div class="flex items-center justify-between mb-8 relative">
                    <!-- Progress Line -->
                    <div class="absolute top-1/2 left-0 right-0 h-1.5 bg-gray-100 transform -translate-y-1/2 -z-10 rounded-full overflow-hidden">
                        <div id="progress-line" class="progress-line h-full rounded-full w-0"></div>
                    </div>

                    <!-- Step 1 -->
                    <div class="step w-10 h-10 rounded-full border-2 border-gray-300 bg-white flex items-center justify-center font-semibold text-gray-500 step-1 active">
                        <span>1</span>
                    </div>

                    <!-- Step 2 -->
                    <div class="step w-10 h-10 rounded-full border-2 border-gray-300 bg-white flex items-center justify-center font-semibold text-gray-500 step-2">
                        <span>2</span>
                    </div>

                    <!-- Step 3 -->
                    <div class="step w-10 h-10 rounded-full border-2 border-gray-300 bg-white flex items-center justify-center font-semibold text-gray-500 step-3">
                        <span>3</span>
                    </div>
                </div>

                <!-- Traditional Laravel Form (Hidden) -->
                <form method="POST" action="{{ route('register') }}" id="traditionalRegisterForm" class="hidden-form">
                    @csrf

                    <!-- Personal Information -->
                    <input type="text" name="name" id="form-name" value="{{ old('name') }}">
                    <input type="email" name="email" id="form-email" value="{{ old('email') }}">
                    <input type="tel" name="phone" id="form-phone" value="{{ old('phone') }}">
                    <input type="password" name="password" id="form-password">
                    <input type="password" name="password_confirmation" id="form-password-confirmation">
                    <input type="checkbox" name="agree_terms" id="form-agree-terms" value="1" {{ old('agree_terms') ? 'checked' : '' }}>
                    <input type="checkbox" name="marketing_emails" id="form-marketing-emails" value="1" {{ old('marketing_emails') ? 'checked' : '' }}>
                </form>

                <!-- Multi-step UI Form -->
                <div id="multiStepForm">
                    <!-- Step 1: Personal Information -->
                    <div id="step-1" class="step-content active space-y-5">
                        <!-- Full Name -->
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-gray-700">Full Name</label>
                            <div class="input-group">
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class='bx bx-user text-gray-400 text-xl'></i>
                                    </div>
                                    <input type="text"
                                           id="name"
                                           name="name"
                                           value="{{ old('name') }}"
                                           class="w-full pl-12 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition placeholder-gray-400 text-sm lg:text-base @error('name') input-error @enderror"
                                           placeholder="Enter your full name"
                                           required>
                                </div>
                                @error('name')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Email -->
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
                                           required>
                                </div>
                                @error('email')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-gray-700">Phone Number</label>
                            <div class="input-group">
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class='bx bx-phone text-gray-400 text-xl'></i>
                                    </div>
                                    <input type="tel"
                                           id="phone"
                                           name="phone"
                                           value="{{ old('phone') }}"
                                           class="w-full pl-12 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition placeholder-gray-400 text-sm lg:text-base @error('phone') input-error @enderror"
                                           placeholder="Enter your phone number"
                                           required>
                                </div>
                                @error('phone')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <button type="button"
                                onclick="goToStep(2)"
                                class="w-full btn-primary text-white py-3 rounded-xl font-semibold transition shadow-lg hover:shadow-xl">
                            Continue to Next Step
                            <i class='bx bx-chevron-right ml-2'></i>
                        </button>
                    </div>

                    <!-- Step 2: Password -->
                    <div id="step-2" class="step-content space-y-5">
                        <!-- Password -->
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-gray-700">Create Password</label>
                            <div class="input-group">
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class='bx bx-lock-alt text-gray-400 text-xl'></i>
                                    </div>
                                    <input type="password"
                                           id="password"
                                           name="password"
                                           oninput="checkPasswordStrength()"
                                           class="w-full pl-12 pr-12 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition placeholder-gray-400 text-sm lg:text-base @error('password') input-error @enderror"
                                           placeholder="Create a strong password"
                                           required>
                                    <button type="button"
                                            onclick="togglePassword('password')"
                                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 transition">
                                        <i class='bx bx-hide' id="password-toggle-icon"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror

                                <!-- Password Strength -->
                                <div id="password-strength" class="hidden mt-2">
                                    <div class="flex justify-between items-center mb-1">
                                        <span class="text-xs text-gray-500">Password strength:</span>
                                        <span id="password-strength-text" class="text-xs font-medium"></span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div id="password-strength-bar" class="h-2 rounded-full transition-all duration-300"></div>
                                    </div>
                                    <div class="mt-2 text-xs text-gray-500">
                                        <p>• At least 8 characters</p>
                                        <p>• Mix of uppercase & lowercase</p>
                                        <p>• Include numbers or symbols</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Confirm Password -->
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-gray-700">Confirm Password</label>
                            <div class="input-group">
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class='bx bx-lock text-gray-400 text-xl'></i>
                                    </div>
                                    <input type="password"
                                           id="password_confirmation"
                                           name="password_confirmation"
                                           class="w-full pl-12 pr-12 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition placeholder-gray-400 text-sm lg:text-base"
                                           placeholder="Confirm your password"
                                           required>
                                    <button type="button"
                                            onclick="togglePassword('password_confirmation')"
                                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 transition">
                                        <i class='bx bx-hide' id="confirm-password-toggle-icon"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="flex space-x-3">
                            <button type="button"
                                    onclick="goToStep(1)"
                                    class="flex-1 btn-secondary text-white py-3 rounded-xl font-semibold transition flex items-center justify-center">
                                <i class='bx bx-chevron-left mr-2'></i>
                                Back
                            </button>
                            <button type="button"
                                    onclick="goToStep(3)"
                                    class="flex-1 btn-primary text-white py-3 rounded-xl font-semibold transition">
                                Continue
                                <i class='bx bx-chevron-right ml-2'></i>
                            </button>
                        </div>
                    </div>

                    <!-- Step 3: Terms -->
                    <div id="step-3" class="step-content space-y-5">
                        <!-- Terms Agreement -->
                        <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 space-y-3 @error('agree_terms') border-red-200 bg-red-50 @enderror">
                            <label class="flex items-start space-x-3 cursor-pointer">
                                <input type="checkbox"
                                       id="agree_terms"
                                       name="agree_terms"
                                       value="1"
                                       {{ old('agree_terms') ? 'checked' : '' }}
                                       class="w-5 h-5 text-primary-500 bg-white border-gray-300 rounded focus:ring-primary-500 mt-1">
                                <span class="text-gray-700 text-sm flex-1">
                                    I agree to the
                                    <a href="#" class="text-primary-500 hover:text-primary-600 font-medium">Terms of Service</a>
                                    and
                                    <a href="#" class="text-primary-500 hover:text-primary-600 font-medium">Privacy Policy</a>
                                    <p class="text-gray-500 text-xs mt-1">You must agree to our terms to continue.</p>
                                </span>
                            </label>
                            @error('agree_terms')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Marketing Preference -->
                        <div class="bg-gray-50 border border-gray-200 rounded-xl p-4">
                            <label class="flex items-start space-x-3 cursor-pointer">
                                <input type="checkbox"
                                       id="marketing_emails"
                                       name="marketing_emails"
                                       value="1"
                                       {{ old('marketing_emails') ? 'checked' : '' }}
                                       class="w-5 h-5 text-primary-500 bg-white border-gray-300 rounded focus:ring-primary-500 mt-1">
                                <span class="text-gray-700 text-sm">
                                    Yes, I'd like to receive special offers and FoodOrder updates
                                    <p class="text-gray-500 text-xs mt-1">You can unsubscribe anytime.</p>
                                </span>
                            </label>
                        </div>

                        <div class="flex space-x-3">
                            <button type="button"
                                    onclick="goToStep(2)"
                                    class="flex-1 btn-secondary text-white py-3 rounded-xl font-semibold transition flex items-center justify-center">
                                <i class='bx bx-chevron-left mr-2'></i>
                                Back
                            </button>
                            <button type="button"
                                    id="submit-register-btn"
                                    class="flex-1 btn-primary text-white py-3 rounded-xl font-semibold transition flex items-center justify-center space-x-2 disabled:opacity-50 disabled:cursor-not-allowed shadow-lg hover:shadow-xl">
                                <i class='bx bx-loader-circle bx-spin hidden' id="register-spinner"></i>
                                <span id="register-text">Create Account</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Login Link -->
                <div class="text-center mt-6 pt-5 border-t border-gray-100">
                    <p class="text-gray-600 text-sm">
                        Already have an account?
                        <a href="{{ route('login') }}" class="text-primary-500 hover:text-primary-600 font-semibold transition ml-1">
                            Sign in here
                        </a>
                    </p>
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
                <!-- Heading -->
                <div class="text-center mb-10">
                    <h2 class="text-3xl font-bold text-white mb-4">Start Your Food Journey</h2>
                    <p class="text-lg text-white opacity-90">Join thousands enjoying delicious meals delivered to their door</p>
                </div>

                <!-- Two Illustrations -->
                <div class="flex flex-col lg:flex-row items-center justify-center gap-8 mb-10">
                    <!-- First Illustration -->
                    <div class="flex-1 flex flex-col items-center">
                        <div class="mb-8 text-center animate-float-delayed">
                            <div class="relative w-48 h-48 lg:w-56 lg:h-56 mx-auto mb-4">
                                <img src="{{ asset('assets/pancakes.svg') }}"
                                     alt="Pancakes Illustration"
                                     class="w-full h-full object-contain drop-shadow-lg">
                                <!-- Decorative elements -->
                                <div class="absolute -top-3 -left-3 w-10 h-10 bg-red-300 rounded-full opacity-70 animate-pulse" style="animation-delay: 0.2s"></div>
                                <div class="absolute -bottom-2 -right-2 w-8 h-8 bg-amber-300 rounded-full opacity-60 animate-pulse" style="animation-delay: 0.5s"></div>
                            </div>
                            <p class="text-white font-medium text-lg">Fluffy Pancakes</p>
                            <p class="text-white opacity-80 text-sm mt-1">Enjoy pancakes made with love and care</p>
                        </div>
                    </div>
                    <!-- Second Illustration -->
                    <div class="flex-1 flex flex-col items-center">
                        <div class="mb-8 text-center animate-float">
                            <div class="relative w-48 h-48 lg:w-56 lg:h-56 mx-auto mb-4">
                                <img src="{{ asset('assets/delivery.svg') }}"
                                     alt="Breakfast Illustration"
                                     class="w-full h-full object-contain drop-shadow-lg">
                                <!-- Decorative elements -->
                                <div class="absolute -top-2 -right-2 w-8 h-8 bg-yellow-300 rounded-full opacity-70 animate-pulse"></div>
                                <div class="absolute -bottom-3 -left-3 w-10 h-10 bg-orange-300 rounded-full opacity-60 animate-pulse" style="animation-delay: 0.3s"></div>
                            </div>
                            <p class="text-white font-medium text-lg">Delicious Breakfast</p>
                            <p class="text-white opacity-80 text-sm mt-1">Fast delivery fresh breakfast on front your door</p>
                        </div>
                    </div>
                </div>

                <!-- Benefits -->
                <div class="grid grid-cols-3 gap-4 lg:gap-6 mt-8 px-4">
                    <div class="text-center group cursor-pointer">
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center mx-auto mb-3 transition-all duration-300 group-hover:bg-opacity-30 group-hover:scale-110">
                            <i class='bx bx-gift text-2xl text-white'></i>
                        </div>
                        <p class="text-sm font-medium text-white">Welcome Offer</p>
                        <p class="text-xs text-white opacity-80 mt-1">20% off first order</p>
                    </div>

                    <div class="text-center group cursor-pointer">
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center mx-auto mb-3 transition-all duration-300 group-hover:bg-opacity-30 group-hover:scale-110">
                            <i class='bx bx-timer text-2xl text-white'></i>
                        </div>
                        <p class="text-sm font-medium text-white">Fast Delivery</p>
                        <p class="text-xs text-white opacity-80 mt-1">30 min or less</p>
                    </div>

                    <div class="text-center group cursor-pointer">
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center mx-auto mb-3 transition-all duration-300 group-hover:bg-opacity-30 group-hover:scale-110">
                            <i class='bx bx-dollar-circle text-2xl text-white'></i>
                        </div>
                        <p class="text-sm font-medium text-white">Easy Payment</p>
                        <p class="text-xs text-white opacity-80 mt-1">Multiple options</p>
                    </div>
                </div>

                <!-- Testimonial -->
                <div class="text-center mt-10 pt-8 border-t border-white border-opacity-20">
                    <p class="text-white italic opacity-90">"FoodOrder has changed how I eat! Delicious meals delivered in minutes."</p>
                    <p class="text-white text-sm opacity-70 mt-2">- Sarah, FoodOrder Customer</p>
                </div>
            </div>

            <!-- Floating Elements -->
            <div class="absolute top-1/4 left-10 w-6 h-6 bg-white bg-opacity-30 rounded-full animate-pulse"></div>
            <div class="absolute bottom-1/4 right-10 w-8 h-8 bg-white bg-opacity-30 rounded-full animate-pulse" style="animation-delay: 0.5s"></div>
            <div class="absolute top-3/4 left-1/4 w-4 h-4 bg-white bg-opacity-30 rounded-full animate-pulse" style="animation-delay: 1s"></div>
        </div>
    </div>

    <!-- Notification Toast (untuk session messages) -->
    @if(session('success'))
        <div id="notification" class="fixed top-4 right-4 p-4 rounded-xl text-white font-medium z-50 shadow-lg max-w-sm notification bg-primary-500">
            <div class="flex items-center space-x-2">
                <i class='bx bx-check-circle'></i>
                <span>{{ session('success') }}</span>
            </div>
        </div>

        <script>
            setTimeout(() => {
                const notification = document.getElementById('notification');
                if (notification) {
                    notification.classList.add('hidden');
                }
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
                const notification = document.getElementById('notification');
                if (notification) {
                    notification.classList.add('hidden');
                }
            }, 5000);
        </script>
    @endif

    <script>
        let currentStep = 1;

        // Navigation between steps
        function goToStep(step) {
            // Validate current step before proceeding
            if (step > currentStep) {
                if (!validateCurrentStep()) {
                    return;
                }
            }

            // Hide all steps
            document.querySelectorAll('.step-content').forEach(el => {
                el.classList.remove('active');
            });

            // Remove active class from all steps
            document.querySelectorAll('.step').forEach(el => {
                el.classList.remove('active', 'completed');
            });

            // Show target step
            document.getElementById(`step-${step}`).classList.add('active');

            // Update step indicators
            for (let i = 1; i <= step; i++) {
                const stepEl = document.querySelector(`.step-${i}`);
                if (i === step) {
                    stepEl.classList.add('active');
                } else {
                    stepEl.classList.add('completed');
                    stepEl.innerHTML = '<i class="bx bx-check"></i>';
                }
            }

            // Update progress line
            const progressLine = document.getElementById('progress-line');
            const progressPercentage = ((step - 1) / 2) * 100; // 3 steps = 2 segments
            progressLine.style.width = `${progressPercentage}%`;

            currentStep = step;
        }

        // Validate current step
        function validateCurrentStep() {
            if (currentStep === 1) {
                const name = document.getElementById('name').value;
                const email = document.getElementById('email').value;
                const phone = document.getElementById('phone').value;

                if (!name || !email || !phone) {
                    showNotification('Please fill in all personal information', 'error');
                    return false;
                }

                // Simple email validation
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(email)) {
                    showNotification('Please enter a valid email address', 'error');
                    return false;
                }
            }

            if (currentStep === 2) {
                const password = document.getElementById('password').value;
                const confirmPassword = document.getElementById('password_confirmation').value;

                if (!password || !confirmPassword) {
                    showNotification('Please fill in both password fields', 'error');
                    return false;
                }

                if (password.length < 8) {
                    showNotification('Password must be at least 8 characters long', 'error');
                    return false;
                }

                if (password !== confirmPassword) {
                    showNotification('Passwords do not match', 'error');
                    return false;
                }
            }

            return true;
        }

        // Toggle password visibility
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const iconId = fieldId === 'password' ? 'password-toggle-icon' : 'confirm-password-toggle-icon';
            const icon = document.getElementById(iconId);

            if (field.type === 'password') {
                field.type = 'text';
                icon.className = 'bx bx-show';
            } else {
                field.type = 'password';
                icon.className = 'bx bx-hide';
            }
        }

        // Check password strength
        function checkPasswordStrength() {
            const password = document.getElementById('password').value;
            const strengthDiv = document.getElementById('password-strength');
            const strengthBar = document.getElementById('password-strength-bar');
            const strengthText = document.getElementById('password-strength-text');

            if (password.length === 0) {
                strengthDiv.classList.add('hidden');
                return;
            }

            strengthDiv.classList.remove('hidden');

            let strength = 0;
            let text = '';
            let color = '';

            // Length check
            if (password.length >= 8) strength += 25;

            // Contains lowercase
            if (/[a-z]/.test(password)) strength += 25;

            // Contains uppercase
            if (/[A-Z]/.test(password)) strength += 25;

            // Contains numbers or special characters
            if (/[0-9]/.test(password) || /[^A-Za-z0-9]/.test(password)) strength += 25;

            // Set strength text and color
            if (strength < 25) {
                text = 'Weak';
                color = 'bg-red-500';
            } else if (strength < 50) {
                text = 'Fair';
                color = 'bg-yellow-500';
            } else if (strength < 75) {
                text = 'Good';
                color = 'bg-blue-500';
            } else {
                text = 'Strong';
                color = 'bg-green-500';
            }

            strengthBar.className = `h-2 rounded-full transition-all duration-300 ${color}`;
            strengthBar.style.width = `${strength}%`;
            strengthText.textContent = text;
            strengthText.className = `text-xs font-medium ${color.replace('bg-', 'text-')}`;
        }

        // Show notification (untuk client-side validation)
        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.id = 'client-notification';
            notification.className = `fixed top-4 right-4 p-4 rounded-xl text-white font-medium z-50 shadow-lg max-w-sm notification ${
                type === 'success' ? 'bg-primary-500' :
                type === 'error' ? 'bg-red-500' : 'bg-blue-500'
            }`;

            const icon = type === 'success' ? 'bx-check-circle' :
                        type === 'error' ? 'bx-error' : 'bx-info-circle';

            notification.innerHTML = `
                <div class="flex items-center space-x-2">
                    <i class='bx ${icon}'></i>
                    <span>${message}</span>
                </div>
            `;

            document.body.appendChild(notification);

            setTimeout(() => {
                notification.remove();
            }, 5000);
        }

        // Handle final form submission
        document.getElementById('submit-register-btn').addEventListener('click', function(e) {
            e.preventDefault();

            // Validate all steps first
            for (let i = 1; i <= 3; i++) {
                goToStep(i);
                if (!validateCurrentStep() && i < 3) {
                    showNotification('Please complete all steps correctly', 'error');
                    goToStep(1);
                    return;
                }
            }

            // Check terms agreement
            if (!document.getElementById('agree_terms').checked) {
                showNotification('Please agree to the terms and conditions', 'error');
                return;
            }

            // Copy data from multi-step form to traditional form
            document.getElementById('form-name').value = document.getElementById('name').value;
            document.getElementById('form-email').value = document.getElementById('email').value;
            document.getElementById('form-phone').value = document.getElementById('phone').value;
            document.getElementById('form-password').value = document.getElementById('password').value;
            document.getElementById('form-password-confirmation').value = document.getElementById('password_confirmation').value;
            document.getElementById('form-agree-terms').checked = document.getElementById('agree_terms').checked;
            document.getElementById('form-marketing-emails').checked = document.getElementById('marketing_emails').checked;

            // Show loading state
            const submitBtn = document.getElementById('submit-register-btn');
            const spinner = document.getElementById('register-spinner');
            const registerText = document.getElementById('register-text');

            submitBtn.disabled = true;
            spinner.classList.remove('hidden');
            registerText.textContent = 'Creating Account...';

            // Submit the traditional form
            setTimeout(() => {
                document.getElementById('traditionalRegisterForm').submit();
            }, 500); // Small delay untuk feedback UI
        });

        // Add focus effects to input groups
        document.querySelectorAll('.input-group input').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.parentElement.style.transform = 'translateY(-2px)';
                // Remove error border on focus
                this.classList.remove('input-error');

                // Remove error message if exists
                const parentGroup = this.closest('.space-y-2');
                if (parentGroup) {
                    const errorMessage = parentGroup.querySelector('.error-message');
                    if (errorMessage) {
                        errorMessage.remove();
                    }
                }
            });

            input.addEventListener('blur', function() {
                this.parentElement.parentElement.style.transform = 'translateY(0)';
            });

            // Remove error styling on input
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

        // Auto-focus on name field if empty
        document.addEventListener('DOMContentLoaded', function() {
            const nameField = document.getElementById('name');
            if (nameField && !nameField.value) {
                nameField.focus();
            }

            // Check if there are validation errors and go to appropriate step
            const errors = document.querySelectorAll('.error-message');
            if (errors.length > 0) {
                // If password error exists, go to step 2
                if (document.querySelector('[name="password"]').classList.contains('input-error')) {
                    goToStep(2);
                }
                // If terms error exists, go to step 3
                else if (document.querySelector('[name="agree_terms"]') &&
                         document.querySelector('[name="agree_terms"]').closest('.border-red-200')) {
                    goToStep(3);
                }
            }
        });
    </script>
</body>
</html>
