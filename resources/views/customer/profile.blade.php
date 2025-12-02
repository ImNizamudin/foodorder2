<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} - FoodOrder</title>

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
                        'fade-in': 'fadeIn 0.5s ease-out',
                        'slide-up': 'slideUp 0.3s ease-out',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0', transform: 'translateY(10px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                        slideUp: {
                            '0%': { opacity: '0', transform: 'translateY(20px)' },
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

        .profile-container {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            min-height: 100vh;
        }

        .profile-card {
            background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease;
        }

        .profile-card:hover {
            transform: translateY(-5px);
        }

        .stats-card {
            background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
            color: white;
        }

        .stats-icon {
            background: rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }

        .stats-icon:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: scale(1.05);
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
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%);
            transform: translateY(-2px);
        }

        .avatar-ring {
            box-shadow: 0 0 0 4px white, 0 0 0 8px #dcfce7;
        }

        .progress-bar {
            background: linear-gradient(90deg, #22c55e, #4ade80);
            transition: width 0.6s ease;
        }
    </style>
</head>
<body class="profile-container font-poppins">
    <!-- Navigation -->
    @include('customer.partials.navigation')

    <!-- Profile Content -->
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Welcome Banner -->
        <div class="bg-gradient-to-r from-primary-500 to-primary-600 rounded-2xl p-6 text-white mb-8 shadow-lg animate-fade-in">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold mb-2">Welcome back, {{ auth()->user()->name }}! 👋</h1>
                    <p class="text-green-100">Manage your profile, orders, and preferences here</p>
                </div>
                <div class="hidden md:block">
                    <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center">
                        <i class='bx bx-user-circle text-3xl'></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column - Profile Info & Stats -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Profile Card -->
                <div class="profile-card rounded-2xl p-6 animate-slide-up">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold text-gray-900">Profile Information</h2>
                        <button class="btn-primary text-white px-4 py-2 rounded-xl font-medium transition flex items-center space-x-2">
                            <i class='bx bx-edit'></i>
                            <span>Edit Profile</span>
                        </button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Avatar -->
                        <div class="flex flex-col items-center md:items-start">
                            <div class="relative mb-4">
                                <div class="w-32 h-32 rounded-full bg-gradient-to-br from-primary-100 to-primary-200 flex items-center justify-center avatar-ring">
                                    <i class='bx bx-user text-5xl text-primary-600'></i>
                                </div>
                                <div class="absolute bottom-2 right-2 w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center border-2 border-white">
                                    <i class='bx bx-check text-white text-sm'></i>
                                </div>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900">{{ auth()->user()->name }}</h3>
                            <p class="text-gray-600">{{ auth()->user()->email }}</p>
                        </div>

                        <!-- User Details -->
                        <div class="space-y-4">
                            <div class="space-y-3">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-primary-50 rounded-lg flex items-center justify-center">
                                        <i class='bx bx-envelope text-primary-600'></i>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Email Address</p>
                                        <p class="font-medium text-gray-900">{{ auth()->user()->email }}</p>
                                    </div>
                                </div>

                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-primary-50 rounded-lg flex items-center justify-center">
                                        <i class='bx bx-phone text-primary-600'></i>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Phone Number</p>
                                        <p class="font-medium text-gray-900">{{ auth()->user()->phone ?? 'Not set' }}</p>
                                    </div>
                                </div>

                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-primary-50 rounded-lg flex items-center justify-center">
                                        <i class='bx bx-calendar text-primary-600'></i>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Member Since</p>
                                        <p class="font-medium text-gray-900">{{ auth()->user()->created_at->format('F d, Y') }}</p>
                                    </div>
                                </div>

                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-primary-50 rounded-lg flex items-center justify-center">
                                        <i class='bx bx-shield-alt text-primary-600'></i>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Account Type</p>
                                        <div class="flex items-center space-x-2">
                                            <span class="px-3 py-1 bg-primary-100 text-primary-700 text-sm font-medium rounded-full">
                                                {{ ucfirst(auth()->user()->role) }} User
                                            </span>
                                            <i class='bx bx-badge-check text-primary-500'></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Activity Stats -->
                <div class="profile-card rounded-2xl p-6 animate-slide-up" style="animation-delay: 0.1s">
                    <h2 class="text-xl font-bold text-gray-900 mb-6">Your Activity</h2>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="stats-card rounded-xl p-4 text-center transform hover:scale-105 transition-transform">
                            <div class="stats-icon w-12 h-12 rounded-xl flex items-center justify-center mx-auto mb-3">
                                <i class='bx bx-package text-xl text-white'></i>
                            </div>
                            <p class="text-sm text-green-100 mb-1">Total Orders</p>
                            <p class="text-2xl font-bold">0</p>
                        </div>

                        <div class="stats-card rounded-xl p-4 text-center transform hover:scale-105 transition-transform">
                            <div class="stats-icon w-12 h-12 rounded-xl flex items-center justify-center mx-auto mb-3">
                                <i class='bx bx-time-five text-xl text-white'></i>
                            </div>
                            <p class="text-sm text-green-100 mb-1">Active Orders</p>
                            <p class="text-2xl font-bold">0</p>
                        </div>

                        <div class="stats-card rounded-xl p-4 text-center transform hover:scale-105 transition-transform">
                            <div class="stats-icon w-12 h-12 rounded-xl flex items-center justify-center mx-auto mb-3">
                                <i class='bx bx-heart text-xl text-white'></i>
                            </div>
                            <p class="text-sm text-green-100 mb-1">Favorites</p>
                            <p class="text-2xl font-bold">0</p>
                        </div>

                        <div class="stats-card rounded-xl p-4 text-center transform hover:scale-105 transition-transform">
                            <div class="stats-icon w-12 h-12 rounded-xl flex items-center justify-center mx-auto mb-3">
                                <i class='bx bx-star text-xl text-white'></i>
                            </div>
                            <p class="text-sm text-green-100 mb-1">Reviews</p>
                            <p class="text-2xl font-bold">0</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Quick Actions & Account Security -->
            <div class="space-y-8">
                <!-- Quick Actions -->
                <div class="profile-card rounded-2xl p-6 animate-slide-up" style="animation-delay: 0.2s">
                    <h2 class="text-xl font-bold text-gray-900 mb-6">Quick Actions</h2>

                    <div class="space-y-3">
                        <a href="#" class="flex items-center space-x-3 p-3 rounded-xl hover:bg-gray-50 transition">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                <i class='bx bx-edit-alt text-blue-600'></i>
                            </div>
                            <div class="flex-1">
                                <p class="font-medium text-gray-900">Edit Profile</p>
                                <p class="text-sm text-gray-500">Update your personal information</p>
                            </div>
                            <i class='bx bx-chevron-right text-gray-400'></i>
                        </a>

                        <a href="#" class="flex items-center space-x-3 p-3 rounded-xl hover:bg-gray-50 transition">
                            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                                <i class='bx bx-lock-alt text-purple-600'></i>
                            </div>
                            <div class="flex-1">
                                <p class="font-medium text-gray-900">Change Password</p>
                                <p class="text-sm text-gray-500">Update your account password</p>
                            </div>
                            <i class='bx bx-chevron-right text-gray-400'></i>
                        </a>

                        <a href="#" class="flex items-center space-x-3 p-3 rounded-xl hover:bg-gray-50 transition">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                <i class='bx bx-bell text-green-600'></i>
                            </div>
                            <div class="flex-1">
                                <p class="font-medium text-gray-900">Notifications</p>
                                <p class="text-sm text-gray-500">Manage notification preferences</p>
                            </div>
                            <i class='bx bx-chevron-right text-gray-400'></i>
                        </a>

                        <a href="#" class="flex items-center space-x-3 p-3 rounded-xl hover:bg-gray-50 transition">
                            <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center">
                                <i class='bx bx-help-circle text-orange-600'></i>
                            </div>
                            <div class="flex-1">
                                <p class="font-medium text-gray-900">Help & Support</p>
                                <p class="text-sm text-gray-500">Get help or contact support</p>
                            </div>
                            <i class='bx bx-chevron-right text-gray-400'></i>
                        </a>
                    </div>
                </div>

                <!-- Account Security -->
                <div class="profile-card rounded-2xl p-6 animate-slide-up" style="animation-delay: 0.3s">
                    <h2 class="text-xl font-bold text-gray-900 mb-6">Account Security</h2>

                    <div class="space-y-4">
                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm font-medium text-gray-700">Email Verification</span>
                                <span class="px-2 py-1 bg-green-100 text-green-700 text-xs font-medium rounded-full">
                                    Verified
                                </span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="progress-bar h-2 rounded-full w-full"></div>
                            </div>
                        </div>

                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm font-medium text-gray-700">Phone Verification</span>
                                <span class="px-2 py-1 bg-yellow-100 text-yellow-700 text-xs font-medium rounded-full">
                                    {{ auth()->user()->phone ? 'Pending' : 'Not Set' }}
                                </span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="progress-bar h-2 rounded-full w-{{ auth()->user()->phone ? '50' : '0' }}"></div>
                            </div>
                        </div>

                        <div class="pt-4 border-t border-gray-100">
                            <p class="text-sm text-gray-600 mb-3">Last password change: Never</p>
                            <button class="w-full btn-secondary text-gray-700 py-3 rounded-xl font-medium transition flex items-center justify-center space-x-2">
                                <i class='bx bx-shield-quarter'></i>
                                <span>Change Password</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="mt-12 py-6 border-t border-gray-200">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center text-gray-600 text-sm">
                <p>&copy; 2024 FoodOrder. All rights reserved.</p>
                <p class="mt-1">Delivering happiness to your doorstep since {{ auth()->user()->created_at->format('Y') }}</p>
            </div>
        </div>
    </div>

    <script>
        // Profile completion calculation
        function calculateProfileCompletion() {
            let completion = 25; // Base 25% for having an account

            const name = document.querySelector('h3.text-lg')?.textContent?.trim();
            const email = document.querySelector('p.font-medium.text-gray-900:nth-of-type(1)')?.textContent?.trim();
            const phoneElement = document.querySelector('p.font-medium.text-gray-900:nth-of-type(2)');

            if (name && name !== '') completion += 25;
            if (email && email !== '') completion += 25;
            if (phoneElement && phoneElement.textContent !== 'Not set') completion += 25;

            return Math.min(completion, 100);
        }

        // Update progress bar on page load
        document.addEventListener('DOMContentLoaded', function() {
            const completion = calculateProfileCompletion();
            const progressBar = document.querySelector('.progress-bar');
            if (progressBar) {
                progressBar.style.width = `${completion}%`;

                // Update completion text
                const completionText = document.createElement('p');
                completionText.className = 'text-xs text-gray-500 mt-2';
                completionText.textContent = `Profile ${completion}% complete`;
                progressBar.parentElement.parentElement.appendChild(completionText);
            }

            // Add click effects to cards
            document.querySelectorAll('.stats-card').forEach(card => {
                card.addEventListener('click', function() {
                    this.style.transform = 'scale(0.95)';
                    setTimeout(() => {
                        this.style.transform = 'scale(1.05)';
                    }, 150);
                });
            });

            // Avatar animation
            const avatar = document.querySelector('.avatar-ring');
            if (avatar) {
                avatar.addEventListener('mouseenter', function() {
                    this.style.boxShadow = '0 0 0 4px white, 0 0 0 8px #22c55e, 0 0 20px rgba(34, 197, 94, 0.5)';
                });

                avatar.addEventListener('mouseleave', function() {
                    this.style.boxShadow = '0 0 0 4px white, 0 0 0 8px #dcfce7';
                });
            }
        });
    </script>
</body>
</html>
