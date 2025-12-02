<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>

    @include('customer.partials.head')

    <style>
        /* 🎨 Enhanced Color System */
        :root {
            --appetite-orange: #FB923C;
            --fresh-green: #22C55E;
            --warm-yellow: #F59E0B;
            --trust-blue: #3B82F6;
            --gradient-primary: linear-gradient(135deg, #FF6B6B 0%, #FFA726 50%, #66BB6A 100%);
        }

        /* 🚀 Hero Section dengan Animasi */
        .hero-section {
            min-height: 100vh;
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 50%, #bbf7d0 100%);
            position: relative;
            overflow: hidden;
        }

        .floating-food-icons {
            position: absolute;
            width: 100%;
            height: 100%;
            pointer-events: none;
        }

        .floating-icon {
            position: absolute;
            font-size: 2rem;
            opacity: 0.7;
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
        }

        /* Staggered animations */
        .floating-icon:nth-child(1) { left: 10%; animation-delay: 0s; }
        .floating-icon:nth-child(2) { left: 20%; animation-delay: 1s; }
        .floating-icon:nth-child(3) { left: 30%; animation-delay: 2s; }
        .floating-icon:nth-child(4) { left: 70%; animation-delay: 3s; }
        .floating-icon:nth-child(5) { left: 80%; animation-delay: 4s; }
        .floating-icon:nth-child(6) { left: 90%; animation-delay: 5s; }

        /* Text Animation */
        .text-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .typing-animation {
            overflow: hidden;
            border-right: 3px solid var(--appetite-orange);
            white-space: nowrap;
            animation: typing 3.5s steps(40, end), blink-caret 0.75s step-end infinite;
        }

        @keyframes typing {
            from { width: 0; }
            to { width: 100%; }
        }

        @keyframes blink-caret {
            from, to { border-color: transparent; }
            50% { border-color: var(--appetite-orange); }
        }

        /* Smart Search */
        .smart-search-container {
            position: relative;
            max-width: 600px;
            margin: 0 auto;
        }

        .search-input-wrapper {
            position: relative;
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .search-input {
            width: 100%;
            padding: 20px 60px;
            border: none;
            outline: none;
            font-size: 1.1rem;
            background: transparent;
        }

        .search-input-wrapper i {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            font-size: 1.5rem;
            color: #6B7280;
        }

        .search-input-wrapper .bx-search {
            left: 20px;
        }

        .search-input-wrapper .bx-current-location {
            right: 20px;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .search-input-wrapper .bx-current-location:hover {
            color: var(--fresh-green);
        }

        .search-suggestions {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.15);
            margin-top: 8px;
            padding: 20px;
            display: none;
            z-index: 1000;
        }

        .suggestion-category {
            margin-bottom: 15px;
        }

        .suggestion-category span {
            font-weight: 600;
            color: #374151;
            margin-bottom: 10px;
            display: block;
        }

        .suggestion-chips {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .suggestion-chips button {
            background: #F3F4F6;
            border: none;
            padding: 8px 16px;
            border-radius: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }

        .suggestion-chips button:hover {
            background: var(--fresh-green);
            color: white;
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

        .btn-secondary {
            background: white;
            color: #374151;
            padding: 15px 30px;
            border-radius: 12px;
            border: 2px solid #E5E7EB;
            font-weight: 600;
            font-size: 1.1rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            border-color: var(--fresh-green);
            color: var(--fresh-green);
            transform: translateY(-2px);
        }

        /* Trust Indicators */
        .trust-indicators {
            display: flex;
            justify-content: center;
            gap: 40px;
            margin-top: 40px;
        }

        .trust-item {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #6B7280;
            font-weight: 500;
        }

        .trust-item i {
            font-size: 1.5rem;
            color: var(--fresh-green);
        }

        /* Restaurant Carousel */
        .restaurant-carousel {
            display: flex;
            gap: 20px;
            overflow-x: auto;
            padding: 20px 0;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .restaurant-carousel::-webkit-scrollbar {
            display: none;
        }

        .restaurant-card.featured {
            min-width: 320px;
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            border: 1px solid rgba(0,0,0,0.05);
        }

        .restaurant-card.featured:hover {
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

        .cuisine-tag {
            transition: all 0.2s ease;
        }

        .cuisine-tag:hover {
            background-color: rgba(34, 197, 94, 0.1);
            color: #166534;
            transform: translateY(-1px);
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

        /* Restaurant Carousel Enhancements */
        .restaurant-carousel {
            display: flex;
            gap: 24px;
            overflow-x: auto;
            padding: 20px 0 30px;
            scrollbar-width: thin;
            scrollbar-color: #d1d5db transparent;
            -webkit-overflow-scrolling: touch;
        }

        .restaurant-carousel::-webkit-scrollbar {
            height: 8px;
        }

        .restaurant-carousel::-webkit-scrollbar-track {
            background: #f3f4f6;
            border-radius: 4px;
        }

        .restaurant-carousel::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 4px;
        }

        .restaurant-carousel::-webkit-scrollbar-thumb:hover {
            background: #9ca3af;
        }

        /* Order Button Animation */
        @keyframes subtle-bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-2px); }
        }

        .group-hover\/btn\:animate-bounce {
            animation: subtle-bounce 0.5s ease-in-out;
        }

        /* Image Loading Animation */
        .card-image {
            background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
            position: relative;
        }

        .card-image::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, transparent 0%, rgba(255,255,255,0.1) 100%);
            z-index: 1;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .restaurant-card.featured {
                min-width: 280px;
            }

            .card-image {
                height: 180px;
            }

            .restaurant-carousel {
                gap: 16px;
                padding: 16px 0 24px;
            }

            .card-badge {
                font-size: 0.7rem;
                padding: 4px 12px;
            }
        }

        /* Hover Effect for Entire Card */
        .restaurant-card.featured::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, transparent 0%, rgba(34, 197, 94, 0.03) 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
            pointer-events: none;
            border-radius: 20px;
            z-index: 1;
        }

        .restaurant-card.featured:hover::before {
            opacity: 1;
        }

        .overlay-gradient {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 60%;
            background: linear-gradient(transparent, rgba(0,0,0,0.1));
        }

        /* Category Grid */
        .categories-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .category-card {
            background: white;
            padding: 30px 20px;
            border-radius: 16px;
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
            border: 2px solid transparent;
        }

        .category-card:hover {
            transform: translateY(-5px);
            border-color: var(--fresh-green);
            box-shadow: 0 15px 40px rgba(0,0,0,0.1);
        }

        .category-icon {
            width: 60px;
            height: 60px;
            background: var(--fresh-green);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            font-size: 1.5rem;
            color: white;
        }

        /* How It Works */
        .steps-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
        }

        .step {
            text-align: center;
            padding: 30px 20px;
            background: white;
            border-radius: 16px;
            position: relative;
        }

        .step-number {
            position: absolute;
            top: -15px;
            left: 50%;
            transform: translateX(-50%);
            width: 30px;
            height: 30px;
            background: var(--fresh-green);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        .step i {
            font-size: 3rem;
            color: var(--fresh-green);
            margin-bottom: 15px;
        }

        /* Enhanced Category Cards */
        .category-card {
            background: white;
            padding: 30px 20px;
            border-radius: 20px;
            text-align: center;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            border: 2px solid transparent;
            position: relative;
            overflow: hidden;
        }

        .category-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(34, 197, 94, 0.05), transparent);
            transition: left 0.6s;
        }

        .category-card:hover::before {
            left: 100%;
        }

        .category-card:hover {
            transform: translateY(-8px);
            border-color: #22c55e;
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }

        .category-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            position: relative;
            transition: all 0.3s ease;
        }

        .category-card:hover .category-icon {
            transform: scale(1.1);
        }

        /* Floating animation for category icons */
        @keyframes float-icon {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-5px); }
        }

        .category-card:hover .category-icon {
            animation: float-icon 2s ease-in-out infinite;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .trust-indicators {
                flex-direction: column;
                gap: 20px;
                align-items: center;
            }

            .hero-actions {
                flex-direction: column;
                gap: 15px;
            }

            .restaurant-card.featured {
                min-width: 280px;
            }
        }

        .smart-search-container {
            position: relative;
            max-width: 600px;
            margin: 0 auto 2rem;
        }

        .search-input-wrapper {
            position: relative;
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border: 2px solid transparent;
            transition: all 0.3s ease;
        }

        .search-input-wrapper.search-focused {
            border-color: var(--fresh-green);
            box-shadow: 0 4px 30px rgba(34, 197, 94, 0.15);
        }

        .search-input {
            width: 100%;
            padding: 18px 60px;
            border: none;
            outline: none;
            font-size: 1rem;
            background: transparent;
            color: #333;
        }

        .search-input::placeholder {
            color: #94a3b8;
            transition: color 0.3s ease;
        }

        .search-input-wrapper i.bx-search {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 1.3rem;
            color: #94a3b8;
        }

        .location-btn {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #64748b;
            cursor: pointer;
            padding: 8px;
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        .location-btn:hover {
            background: #f1f5f9;
            color: var(--fresh-green);
        }

        .location-btn i {
            font-size: 1.3rem;
        }

        .animate-spin {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        /* Search Suggestions */
        .search-suggestions {
            position: absolute;
            top: calc(100% + 8px);
            left: 0;
            right: 0;
            background: white;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            padding: 20px;
            z-index: 1000;
            max-height: 500px;
            overflow-y: auto;
            animation: slideDown 0.2s ease-out;
        }

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

        /* Fade In Animation */
        @keyframes fade-in {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-fade-in {
            animation: fade-in 0.3s ease-out;
        }

        /* Suggestion Header */
        .suggestion-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }

        /* Suggestion Chips */
        .suggestion-chips {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 20px;
        }

        .suggestion-chip {
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            transition: all 0.2s ease;
            border: 1px solid transparent;
            cursor: pointer;
        }

        .suggestion-chip:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        /* Suggestion Sections */
        .suggestion-section {
            margin-bottom: 20px;
        }

        .suggestion-section:last-child {
            margin-bottom: 0;
        }

        .section-header {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 12px;
            font-weight: 600;
            color: #374151;
        }

        .section-header i {
            font-size: 1.2rem;
        }

        /* Suggestion List */
        .suggestion-list {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .suggestion-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            border-radius: 12px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            transition: all 0.2s ease;
            cursor: pointer;
            text-align: left;
            width: 100%;
        }

        .suggestion-item:hover {
            background: #f1f5f9;
            border-color: #cbd5e1;
            transform: translateX(4px);
        }

        .suggestion-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .suggestion-content {
            display: flex;
            flex-direction: column;
            flex: 1;
        }

        .suggestion-content small {
            font-size: 0.8rem;
            color: #64748b;
        }

        /* No Results */
        .no-results {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            padding: 40px 20px;
            color: #64748b;
            font-style: italic;
        }

        .no-results i {
            font-size: 1.5rem;
        }

        /* Quick Actions */
        .quick-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 16px;
            padding-top: 16px;
            border-top: 1px solid #e2e8f0;
            font-size: 0.85rem;
            color: #64748b;
        }

        .clear-btn {
            display: flex;
            align-items: center;
            gap: 4px;
            background: none;
            border: none;
            color: #64748b;
            cursor: pointer;
            transition: color 0.2s ease;
            padding: 4px 8px;
            border-radius: 6px;
        }

        .clear-btn:hover {
            color: #dc2626;
            background: #fee2e2;
        }

        /* CTA Buttons */
        .hero-actions {
            display: flex;
            gap: 16px;
            justify-content: center;
            margin-bottom: 3rem;
        }

        .hero-actions .btn-primary {
            background: linear-gradient(135deg, var(--appetite-orange), var(--warm-yellow));
            color: white;
            padding: 16px 32px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 15px rgba(251, 146, 60, 0.3);
        }

        .hero-actions .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(251, 146, 60, 0.4);
        }

        .hero-actions .btn-secondary {
            background: white;
            color: #374151;
            padding: 16px 32px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: 2px solid #e5e7eb;
        }

        .hero-actions .btn-secondary:hover {
            border-color: var(--fresh-green);
            color: var(--fresh-green);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(34, 197, 94, 0.1);
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

        /* Mobile Responsiveness */
        @media (max-width: 768px) {
            .smart-search-container {
                margin: 0 1rem 2rem;
            }

            .search-input {
                padding: 16px 50px;
                font-size: 0.95rem;
            }

            .hero-actions {
                flex-direction: column;
                gap: 12px;
                padding: 0 1rem;
            }

            .hero-actions a {
                width: 100%;
                justify-content: center;
                padding: 14px 24px;
            }

            .search-suggestions {
                position: fixed;
                top: 100px;
                left: 20px;
                right: 20px;
                max-height: 60vh;
            }

            .suggestion-chips {
                overflow-x: auto;
                flex-wrap: nowrap;
                padding-bottom: 8px;
            }

            .suggestion-chip {
                flex-shrink: 0;
            }
        }
    </style>
</head>
<body class="font-poppins" x-data="homePage()">
    <!-- Navigation -->
    @include('customer.partials.navigation')

    <!-- 🚀 Hero Section -->
    <section class="hero-section">
        <!-- Floating Food Icons -->
        <div class="floating-food-icons">
            <div class="floating-icon" style="left: 5%; animation-delay: 0s;">🍔</div>
            <div class="floating-icon" style="left: 15%; animation-delay: 1s;">🍕</div>
            <div class="floating-icon" style="left: 25%; animation-delay: 2s;">🍣</div>
            <div class="floating-icon" style="left: 35%; animation-delay: 3s;">🍜</div>
            <div class="floating-icon" style="left: 65%; animation-delay: 4s;">🍦</div>
            <div class="floating-icon" style="left: 75%; animation-delay: 5s;">🍩</div>
            <div class="floating-icon" style="left: 85%; animation-delay: 6s;">☕</div>
            <div class="floating-icon" style="left: 95%; animation-delay: 7s;">🥗</div>

            <!-- Additional decorative elements -->
            <div class="floating-icon" style="left: 45%; top: 20%; animation-delay: 0.5s; font-size: 1.5rem;">🌮</div>
            <div class="floating-icon" style="left: 55%; top: 80%; animation-delay: 1.5s; font-size: 1.5rem;">🍛</div>
            <div class="floating-icon" style="left: 10%; top: 70%; animation-delay: 2.5s; font-size: 1.5rem;">🥐</div>
            <div class="floating-icon" style="left: 90%; top: 30%; animation-delay: 3.5s; font-size: 1.5rem;">🍹</div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="min-h-screen flex items-center justify-center text-center">
                <div class="hero-content max-w-4xl">
                    <!-- Animated Title -->
                    <h1 class="text-5xl md:text-7xl font-bold mb-6">
                        <span class="text-gradient block p-4">Craving Something</span>
                        <span class="typing-animation block text-gray-900 mt-2">Delicious?</span>
                    </h1>

                    <!-- Subtitle -->
                    <p class="text-xl md:text-2xl text-gray-600 mb-8 leading-relaxed">
                        Discover 100+ restaurants • Fast delivery • Best prices in town
                    </p>

                    <!-- Smart Search Bar -->
                    <div class="smart-search-container mb-8" x-data="smartSearch()" x-init="init()">
                        <div class="search-input-wrapper" :class="{ 'search-focused': isFocused }">
                            <i class='bx bx-search text-gray-400'></i>
                            <input
                                type="text"
                                placeholder="What are you craving? Sushi, Burger, Pizza..."
                                class="search-input"
                                id="mainSearch"
                                x-model="searchQuery"
                                @input="handleSearchInput"
                                @focus="isFocused = true; showSuggestions = true"
                                @blur="onBlur"
                            >
                            <button
                                type="button"
                                class="location-btn"
                                @click="detectLocation"
                                title="Use my current location"
                            >
                                <i class='bx bx-current-location' :class="{ 'animate-spin': isDetectingLocation }"></i>
                            </button>
                        </div>

                        <!-- Auto-suggest Dropdown -->
                        <div
                            class="search-suggestions"
                            x-show="showSuggestions && (searchQuery.length > 0 || showPopular)"
                            x-transition
                            x-cloak
                        >
                            <!-- Popular Suggestions -->
                            <template x-if="searchQuery.length === 0 && showPopular">
                                <div class="popular-suggestions">
                                    <div class="suggestion-header">
                                        <span class="text-sm font-semibold text-gray-700 flex items-center">
                                            <i class='bx bx-trending-up text-primary-500 mr-2'></i>
                                            Popular Searches
                                        </span>
                                        <button
                                            @click="togglePopular"
                                            class="text-xs text-primary-600 hover:text-primary-700"
                                        >
                                            <span x-text="showPopular ? 'Hide' : 'Show'"></span>
                                        </button>
                                    </div>
                                    <div class="suggestion-chips">
                                        <template x-for="category in popularSuggestions.categories" :key="'pop-cat-' + category.id">
                                            <button
                                                @click="selectPopular(category.name, 'category')"
                                                class="suggestion-chip bg-gradient-to-r from-primary-50 to-primary-100 border border-primary-200 hover:from-primary-100 hover:to-primary-200"
                                            >
                                                <i class='bx bx-category text-primary-600 mr-1'></i>
                                                <span x-text="category.name"></span>
                                            </button>
                                        </template>
                                        <template x-for="dish in popularSuggestions.dishes" :key="'pop-dish-' + dish.id">
                                            <button
                                                @click="selectPopular(dish.name, 'dish')"
                                                class="suggestion-chip bg-gradient-to-r from-orange-50 to-orange-100 border border-orange-200 hover:from-orange-100 hover:to-orange-200"
                                            >
                                                <i class='bx bx-bowl-hot text-orange-600 mr-1'></i>
                                                <span x-text="dish.name"></span>
                                            </button>
                                        </template>
                                    </div>
                                </div>
                            </template>

                            <!-- Search Results -->
                            <template x-if="searchQuery.length > 0">
                                <div class="search-results">
                                    <!-- Categories -->
                                    <template x-if="searchResults.categories.length > 0">
                                        <div class="suggestion-section">
                                            <div class="section-header">
                                                <i class='bx bx-category text-blue-500'></i>
                                                <span>Categories</span>
                                            </div>
                                            <div class="suggestion-list">
                                                <template x-for="category in searchResults.categories" :key="'cat-' + category.id">
                                                    <button
                                                        @click="selectSuggestion(category.name, 'category')"
                                                        class="suggestion-item"
                                                    >
                                                        <div class="suggestion-icon bg-blue-100">
                                                            <i class='bx bx-category text-blue-600'></i>
                                                        </div>
                                                        <span x-text="category.name"></span>
                                                    </button>
                                                </template>
                                            </div>
                                        </div>
                                    </template>

                                    <!-- Restaurants -->
                                    <template x-if="searchResults.restaurants.length > 0">
                                        <div class="suggestion-section">
                                            <div class="section-header">
                                                <i class='bx bx-restaurant text-green-500'></i>
                                                <span>Restaurants</span>
                                            </div>
                                            <div class="suggestion-list">
                                                <template x-for="restaurant in searchResults.restaurants" :key="'res-' + restaurant.id">
                                                    <button
                                                        @click="selectSuggestion(restaurant.name, 'restaurant')"
                                                        class="suggestion-item"
                                                    >
                                                        <div class="suggestion-icon bg-green-100">
                                                            <i class='bx bx-store text-green-600'></i>
                                                        </div>
                                                        <span x-text="restaurant.name"></span>
                                                    </button>
                                                </template>
                                            </div>
                                        </div>
                                    </template>

                                    <!-- Dishes -->
                                    <template x-if="searchResults.dishes.length > 0">
                                        <div class="suggestion-section">
                                            <div class="section-header">
                                                <i class='bx bx-food-menu text-orange-500'></i>
                                                <span>Dishes</span>
                                            </div>
                                            <div class="suggestion-list">
                                                <template x-for="dish in searchResults.dishes" :key="'dish-' + dish.id">
                                                    <button
                                                        @click="selectSuggestion(dish.name, 'dish')"
                                                        class="suggestion-item"
                                                    >
                                                        <div class="suggestion-icon bg-orange-100">
                                                            <i class='bx bx-bowl-hot text-orange-600'></i>
                                                        </div>
                                                        <div class="suggestion-content">
                                                            <span x-text="dish.name"></span>
                                                            <small class="text-gray-500" x-text="dish.restaurant?.name || ''"></small>
                                                        </div>
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
                                        <div class="no-results">
                                            <i class='bx bx-search text-gray-400'></i>
                                            <span>No results found for "<span x-text="searchQuery"></span>"</span>
                                        </div>
                                    </template>
                                </div>
                            </template>

                            <!-- Quick Actions -->
                            <div class="quick-actions">
                                <small>💡 Try: "pizza", "sushi", or "burger"</small>
                                <button @click="clearSearch" class="clear-btn">
                                    <i class='bx bx-x'></i>
                                    Clear
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- CTA Buttons -->
                    <div class="hero-actions flex gap-4 justify-center mb-8">
                        <a href="{{ route('customer.restaurants') }}"
                        class="btn-primary flex items-center gap-2 group">
                            <i class='bx bx-rocket text-lg group-hover:animate-bounce'></i>
                            <span>Order Now</span>
                            <i class='bx bx-chevron-right text-lg group-hover:translate-x-1 transition-transform'></i>
                        </a>
                    </div>

                    <!-- Trust Indicators -->
                    <div class="trust-indicators">
                        <div class="trust-item">
                            <i class='bx bx-check-shield'></i>
                            <span>100% Food Safety</span>
                        </div>
                        <div class="trust-item">
                            <i class='bx bx-time-five'></i>
                            <span>30min Delivery</span>
                        </div>
                        <div class="trust-item">
                            <i class='bx bx-star'></i>
                            <span>4.8/5 Rating</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 🔥 Featured Restaurants -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="section-header flex justify-between items-center mb-8">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900">🔥 Popular Near You</h2>
                    <p class="text-gray-600 mt-2">Based on your location and preferences</p>
                </div>
                <a href="{{ route('customer.restaurants') }}" class="text-primary-600 hover:text-primary-700 font-semibold">
                    View All →
                </a>
            </div>

            <div class="restaurant-carousel">
                @foreach($featuredRestaurants as $restaurant)
                    <div class="restaurant-card featured group">
                        <!-- Badge -->
                        <div class="card-badge">
                            @if($loop->first)
                                🏆 #1 Most Popular
                            @elseif($loop->iteration <= 3)
                                ⭐ Top Rated
                            @else
                                🔥 Trending
                            @endif
                        </div>

                        <!-- Restaurant Image -->
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
                                <span class="text-sm font-semibold text-gray-800">{{ $restaurant->delivery_time }} min</span>
                            </div>

                            <!-- Rating Badge -->
                            <div class="absolute top-4 right-4 z-20 bg-black/70 backdrop-blur-sm px-3 py-1.5 rounded-full flex items-center gap-1">
                                <i class='bx bxs-star text-yellow-400 text-sm'></i>
                                <span class="text-sm font-semibold text-white">{{ number_format($restaurant->rating, 1) }}</span>
                            </div>
                        </div>

                        <!-- Card Content -->
                        <div class="card-content p-6">
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

                                    @if(count($cuisineTypes) > 0)
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
                                        <span>{{ number_format($restaurant->rating, 1) }}</span>
                                        <span class="text-gray-400">({{ $restaurant->order_count ?? '150+' }})</span>
                                    </div>
                                    <span class="text-gray-400">•</span>
                                    <span class="flex items-center gap-1">
                                        <i class='bx bx-time'></i>
                                        {{ $restaurant->delivery_time }} min
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
                                        • {{ $restaurant->delivery_fee > 0 ? 'Delivery: Rp ' . number_format($restaurant->delivery_fee, 0, ',', '.') : 'Free delivery' }}
                                    </span>
                                </div>
                                <span class="orders-today text-sm text-gray-500 flex items-center gap-1">
                                    <i class='bx bx-trending-up text-primary-500'></i>
                                    {{ $restaurant->order_count ?? '150+' }} orders today
                                </span>
                            </div>

                            <!-- Order Button -->
                            <a href="{{ route('customer.restaurants.show', $restaurant) }}"
                            class="order-btn w-full bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 text-white py-3 rounded-xl font-semibold transition-all duration-300 flex items-center justify-center gap-2 group/btn shadow-md hover:shadow-lg">
                                <i class='bx bx-cart text-lg group-hover/btn:animate-bounce'></i>
                                <span>Order Now</span>
                                <i class='bx bx-chevron-right text-lg transform group-hover/btn:translate-x-1 transition-transform'></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- 🍽️ Category Exploration -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="section-header text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900">🍽️ Browse by Category</h2>
                <p class="text-gray-600 mt-2">Find exactly what you're craving</p>
            </div>

            <div class="categories-grid">
                @foreach($categories as $category)
                    <!-- Category Card -->
                    <a href="{{ route('customer.restaurants') }}?category={{ urlencode($category->name) }}"
                    class="category-card group block"
                    data-category="{{ Str::slug($category->name) }}"
                    onclick="trackCategoryClick('{{ $category->name }}')">

                        <div class="category-icon relative">
                            <!-- Gradient Background -->
                            <div class="absolute inset-0 bg-gradient-to-br {{ $category->color }} rounded-full opacity-90 group-hover:opacity-100 transition-opacity"></div>
                            <!-- Category Icon -->
                            <i class='{{ $category->icon }} flaticon-icon text-white relative z-10'></i>

                            <!-- Hover Effect -->
                            <div class="absolute inset-0 bg-white rounded-full opacity-0 group-hover:opacity-20 transition-opacity"></div>
                        </div>

                        <h4 class="font-semibold text-gray-900 text-lg mb-2 group-hover:text-primary-600 transition-colors">
                            {{ $category->name }}
                        </h4>

                        <p class="text-gray-500 text-sm mb-3 leading-relaxed">
                            {{ $category->description ? Str::limit($category->description, 50) : 'Various delicious options' }}
                        </p>

                        <div class="flex items-center justify-between">
                            <span class="restaurant-count text-primary-600 text-sm font-medium group-hover:text-primary-700 transition-colors">
                                {{ $category->menu_items_count }} items
                            </span>

                            <!-- Hover Arrow -->
                            <div class="opacity-0 group-hover:opacity-100 transform -translate-x-2 group-hover:translate-x-0 transition-all">
                                <i class='bx bx-chevron-right text-primary-500 text-xl'></i>
                            </div>
                        </div>

                        <!-- Click Ripple Effect -->
                        <div class="absolute inset-0 overflow-hidden rounded-2xl">
                            <div class="absolute inset-0 bg-primary-500 opacity-0 group-hover:opacity-5 transition-opacity"></div>
                        </div>
                    </a>
                @endforeach
            </div>

            <!-- View All Categories Button -->
            <div class="text-center mt-12">
                <a href="{{ route('customer.restaurants') }}"
                class="inline-flex items-center gap-2 px-6 py-3 bg-white border border-gray-300 rounded-xl font-semibold text-gray-700 hover:border-primary-500 hover:text-primary-600 transition-all duration-300">
                    <span>View All Categories</span>
                    <i class='bx bx-chevron-right text-lg'></i>
                </a>
            </div>
        </div>
    </section>

    <!-- 🚀 How It Works -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="section-header text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900">🚀 How FoodOrder Works</h2>
                <p class="text-gray-600 mt-2">Get your favorite food in 4 simple steps</p>
            </div>

            <div class="steps-container">
                <div class="step">
                    <div class="step-number">1</div>
                    <i class='bx bx-search-alt-2'></i>
                    <h4 class="font-semibold text-gray-900 text-lg mb-2">Search & Choose</h4>
                    <p class="text-gray-500">Find restaurants near you</p>
                </div>

                <div class="step">
                    <div class="step-number">2</div>
                    <i class='bx bx-food-menu'></i>
                    <h4 class="font-semibold text-gray-900 text-lg mb-2">Select Food</h4>
                    <p class="text-gray-500">Browse menu and add to cart</p>
                </div>

                <div class="step">
                    <div class="step-number">3</div>
                    <i class='bx bx-credit-card'></i>
                    <h4 class="font-semibold text-gray-900 text-lg mb-2">Pay Securely</h4>
                    <p class="text-gray-500">Multiple payment options</p>
                </div>

                <div class="step">
                    <div class="step-number">4</div>
                    <i class='bx bx-truck'></i>
                    <h4 class="font-semibold text-gray-900 text-lg mb-2">Fast Delivery</h4>
                    <p class="text-gray-500">Track your order in real-time</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 📱 Mobile App CTA -->
    <section class="py-16 bg-gradient-to-r from-primary-500 to-primary-600">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="app-content grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="app-text text-white">
                    <h2 class="text-4xl font-bold mb-4">📱 Get the FoodOrder App</h2>
                    <p class="text-xl text-primary-100 mb-8">Faster ordering, exclusive deals, and better experience</p>

                    <div class="app-features space-y-4 mb-8">
                        <div class="feature flex items-center gap-3">
                            <i class='bx bx-rocket text-2xl'></i>
                            <span class="text-lg">Faster ordering</span>
                        </div>
                        <div class="feature flex items-center gap-3">
                            <i class='bx bx-gift text-2xl'></i>
                            <span class="text-lg">Exclusive deals</span>
                        </div>
                        <div class="feature flex items-center gap-3">
                            <i class='bx bx-map text-2xl'></i>
                            <span class="text-lg">Live order tracking</span>
                        </div>
                    </div>

                    <div class="download-buttons flex gap-4 flex-wrap">
                        <button class="app-store-btn bg-black text-white px-6 py-3 rounded-xl flex items-center gap-3 hover:bg-gray-800 transition">
                            <i class='bx bxl-apple text-2xl'></i>
                            <div class="text-left">
                                <span class="text-xs">Download on the</span>
                                <strong class="block">App Store</strong>
                            </div>
                        </button>

                        <button class="play-store-btn bg-black text-white px-6 py-3 rounded-xl flex items-center gap-3 hover:bg-gray-800 transition">
                            <i class='bx bxl-play-store text-2xl'></i>
                            <div class="text-left">
                                <span class="text-xs">Get it on</span>
                                <strong class="block">Google Play</strong>
                            </div>
                        </button>
                    </div>
                </div>

                <div class="app-preview hidden lg:block">
                    <div class="bg-white rounded-3xl p-8 shadow-2xl transform rotate-3 hover:rotate-0 transition-transform duration-300 flex">
                        <div class="w-64 h-96 bg-gradient-to-br from-primary-100 to-primary-200 rounded-2xl flex items-center justify-center">
                            <div class="text-center text-primary-600">
                                <i class='bx bx-restaurant text-6xl mb-4'></i>
                                <p class="font-bold text-xl">FoodOrder App</p>
                                <p class="text-sm mt-2">Download Now</p>
                            </div>
                        </div>
                        <div class="w-64 h-96 bg-gradient-to-br from-orange-50 to-green-50 rounded-2xl overflow-hidden relative">
                            <!-- App Screen Content -->
                            <div class="absolute inset-0 p-4">
                                <!-- Header -->
                                <div class="flex items-center justify-between mb-6">
                                    <div class="flex items-center space-x-2">
                                        <div class="w-8 h-8 bg-primary-500 rounded-lg flex items-center justify-center">
                                            <i class='bx bx-restaurant text-white text-sm'></i>
                                        </div>
                                        <span class="font-bold text-gray-800 text-sm">FoodOrder</span>
                                    </div>
                                    <div class="text-xs text-gray-500">12:30</div>
                                </div>

                                <!-- Hero Section dalam app -->
                                <div class="text-center mb-6">
                                    <h3 class="font-bold text-gray-800 text-lg mb-2">Hello, Foodie! 👋</h3>
                                    <p class="text-gray-600 text-xs mb-4">What do you want to eat today?</p>

                                    <!-- Search Bar dalam app -->
                                    <div class="relative mb-4">
                                        <i class='bx bx-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm'></i>
                                        <input type="text" placeholder="Search food..."
                                            class="w-full pl-9 pr-4 py-2 bg-white border border-gray-200 rounded-xl text-xs focus:outline-none focus:border-primary-300">
                                        </div>
                                    </div>

                                    <!-- Quick Categories dalam app -->
                                    <div class="grid grid-cols-3 gap-2 mb-4">
                                        <div class="text-center">
                                            <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center mx-auto mb-1">
                                                <i class='bx bx-burger text-orange-600 text-lg'></i>
                                            </div>
                                            <span class="text-xs text-gray-600">Burger</span>
                                        </div>
                                        <div class="text-center">
                                            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mx-auto mb-1">
                                                <i class='bx bx-sushi text-green-600 text-lg'></i>
                                            </div>
                                            <span class="text-xs text-gray-600">Sushi</span>
                                        </div>
                                        <div class="text-center">
                                            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mx-auto mb-1">
                                                <i class='bx bx-pizza text-blue-600 text-lg'></i>
                                            </div>
                                            <span class="text-xs text-gray-600">Pizza</span>
                                        </div>
                                    </div>

                                    <!-- Featured Restaurant Card -->
                                    <div class="bg-white rounded-xl p-3 shadow-sm border border-gray-100">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-12 h-12 bg-gradient-to-br from-orange-400 to-red-500 rounded-lg flex items-center justify-center">
                                                <i class='bx bx-bowl-rice text-white text-lg'></i>
                                            </div>
                                            <div class="flex-1">
                                                <h4 class="font-semibold text-gray-800 text-sm">Sushi Master</h4>
                                                <div class="flex items-center space-x-1">
                                                    <i class='bx bxs-star text-yellow-400 text-xs'></i>
                                                    <span class="text-gray-600 text-xs">4.8 • 25min</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Floating action button -->
                                    <div class="absolute bottom-4 right-4 w-10 h-10 bg-primary-500 rounded-full flex items-center justify-center shadow-lg">
                                        <i class='bx bx-cart text-white text-lg'></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    @include('customer.partials.footer')

    <script>
        function homePage() {
            return {
                searchQuery: '',
                showSuggestions: false,
                searchSuggestions: {
                    categories: [],
                    restaurants: [],
                    dishes: []
                },
                searchTimeout: null,

                init() {
                    // Track user journey
                    this.trackUserJourney();
                },

                handleSearchInput() {
                    clearTimeout(this.searchTimeout);
                    this.searchTimeout = setTimeout(() => {
                        if (this.searchQuery.length > 2) {
                            this.fetchSearchSuggestions();
                        }
                    }, 300);
                },

                async fetchSearchSuggestions() {
                    try {
                        const response = await fetch(`/api/search-suggestions?q=${encodeURIComponent(this.searchQuery)}`);
                        const data = await response.json();
                        this.searchSuggestions = data;
                    } catch (error) {
                        console.error('Error fetching suggestions:', error);
                    }
                },

                selectSuggestion(suggestion) {
                    this.searchQuery = suggestion;
                    this.showSuggestions = false;
                    // Redirect to search results
                    window.location.href = `/restaurants?search=${encodeURIComponent(suggestion)}`;
                },

                selectCategory(categoryName) {
                    this.searchQuery = categoryName;
                    this.showSuggestions = false;
                    window.location.href = `/restaurants?category=${encodeURIComponent(categoryName)}`;
                },

                detectLocation() {
                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(
                            (position) => {
                                const { latitude, longitude } = position.coords;
                                this.updateLocation(latitude, longitude);
                            },
                            (error) => {
                                alert('Unable to get your location. Please enable location services.');
                            }
                        );
                    } else {
                        alert('Geolocation is not supported by this browser.');
                    }
                },

                updateLocation(lat, lng) {
                    // In a real app, you would send this to your backend
                    console.log('Location detected:', lat, lng);
                    alert('Location detected! Showing restaurants near you.');
                },

                trackUserJourney() {
                    const userJourney = {
                        pageLoad: Date.now(),
                        sectionsViewed: new Set(),

                        trackSectionView(sectionName) {
                            if (!this.sectionsViewed.has(sectionName)) {
                                this.sectionsViewed.add(sectionName);
                                console.log(`User viewed: ${sectionName}`);

                                // Track engagement
                                if (this.sectionsViewed.size >= 3) {
                                    console.log('User is highly engaged!');
                                }
                            }
                        }
                    };

                    // Intersection Observer untuk track section views
                    const observer = new IntersectionObserver((entries) => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting) {
                                const sectionName = entry.target.getAttribute('data-section');
                                userJourney.trackSectionView(sectionName);
                            }
                        });
                    }, { threshold: 0.5 });

                    // Observe semua sections
                    document.querySelectorAll('[data-section]').forEach(section => {
                        observer.observe(section);
                    });
                }
            }
        }

        // Add data-section attributes to track user journey
        document.addEventListener('DOMContentLoaded', function() {
            const sections = document.querySelectorAll('section');
            sections.forEach((section, index) => {
                section.setAttribute('data-section', `section-${index + 1}`);
            });
        });


        function smartSearch() {
            return {
                // State
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
                isFocused: false,
                showSuggestions: false,
                showPopular: true,
                isDetectingLocation: false,

                // Utilities
                debounceTimer: null,
                debounceDelay: 300,

                async init() {
                    // Load popular suggestions
                    await this.loadPopularSuggestions();

                    // Handle clicks outside
                    document.addEventListener('click', (e) => {
                        if (!e.target.closest('.smart-search-container')) {
                            this.showSuggestions = false;
                        }
                    });

                    // Keyboard shortcuts
                    document.addEventListener('keydown', (e) => {
                        if (e.key === 'Escape') {
                            this.showSuggestions = false;
                        }
                        if (e.key === 'Enter' && this.searchQuery.trim() && document.activeElement.id === 'mainSearch') {
                            this.performSearch();
                        }
                    });
                },

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
                    }, this.debounceDelay);
                },

                onBlur() {
                    setTimeout(() => {
                        this.isFocused = false;
                        if (!this.isMouseOverSuggestions) {
                            this.showSuggestions = false;
                        }
                    }, 200);
                },

                async fetchSearchResults() {
                    try {
                        const query = this.searchQuery.trim();
                        if (query.length < 2) return;

                        const response = await fetch(`{{ route('api.search-suggestions') }}?q=${encodeURIComponent(query)}`);
                        if (!response.ok) throw new Error('Network response was not ok');

                        const data = await response.json();
                        this.searchResults = data;
                        this.showSuggestions = true;
                    } catch (error) {
                        console.error('Error fetching search results:', error);
                        this.showToast('Error fetching suggestions', 'error');
                    }
                },

                async loadPopularSuggestions() {
                    try {
                        const response = await fetch('{{ route('api.popular-suggestions') }}');
                        const data = await response.json();
                        this.popularSuggestions = data;
                    } catch (error) {
                        console.error('Error loading popular suggestions:', error);
                    }
                },

                selectSuggestion(text, type) {
                    this.searchQuery = text;
                    this.showSuggestions = false;

                    let url = '{{ route('customer.restaurants') }}';

                    switch(type) {
                        case 'category':
                            url += `?category=${encodeURIComponent(text)}`;
                            break;
                        case 'restaurant':
                            url += `?search=${encodeURIComponent(text)}`;
                            break;
                        case 'dish':
                            url += `?search=${encodeURIComponent(text)}`;
                            break;
                    }

                    window.location.href = url;
                },

                selectPopular(text, type) {
                    this.selectSuggestion(text, type);
                },

                performSearch() {
                    if (this.searchQuery.trim()) {
                        window.location.href = `{{ route('customer.restaurants') }}?search=${encodeURIComponent(this.searchQuery.trim())}`;
                    }
                },

                togglePopular() {
                    this.showPopular = !this.showPopular;
                },

                clearSearch() {
                    this.searchQuery = '';
                    this.searchResults = { categories: [], restaurants: [], dishes: [] };
                    this.showPopular = true;
                    document.getElementById('mainSearch').focus();
                },

                detectLocation() {
                    if (!navigator.geolocation) {
                        this.showToast('Geolocation is not supported by your browser', 'error');
                        return;
                    }

                    this.isDetectingLocation = true;

                    navigator.geolocation.getCurrentPosition(
                        async (position) => {
                            const { latitude, longitude } = position.coords;
                            await this.handleLocationSuccess(latitude, longitude);
                            this.isDetectingLocation = false;
                        },
                        (error) => {
                            this.handleLocationError(error);
                            this.isDetectingLocation = false;
                        },
                        {
                            enableHighAccuracy: true,
                            timeout: 10000,
                            maximumAge: 0
                        }
                    );
                },

                async handleLocationSuccess(lat, lng) {
                    this.showToast('Location detected! Showing restaurants near you', 'success');

                    // Simpan location ke localStorage untuk penggunaan nanti
                    localStorage.setItem('userLocation', JSON.stringify({ lat, lng }));

                    // Redirect ke restaurants dengan filter location
                    setTimeout(() => {
                        window.location.href = `{{ route('customer.restaurants') }}?near_me=true&lat=${lat}&lng=${lng}`;
                    }, 1000);
                },

                handleLocationError(error) {
                    let message = 'Unable to get your location.';

                    switch(error.code) {
                        case error.PERMISSION_DENIED:
                            message = 'Location permission denied. Please enable location services.';
                            break;
                        case error.POSITION_UNAVAILABLE:
                            message = 'Location information is unavailable.';
                            break;
                        case error.TIMEOUT:
                            message = 'Location request timed out. Please try again.';
                            break;
                    }

                    this.showToast(message, 'error');
                },

                showToast(message, type = 'info') {
                    // Remove existing toasts
                    const existingToasts = document.querySelectorAll('.custom-toast');
                    existingToasts.forEach(toast => toast.remove());

                    // Create toast element
                    const toast = document.createElement('div');
                    toast.className = `custom-toast fixed top-4 right-4 px-6 py-3 rounded-xl shadow-lg z-50 flex items-center space-x-3 animate-fade-in ${this.getToastClass(type)}`;

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
                },

                getToastClass(type) {
                    const classes = {
                        info: 'bg-blue-50 border border-blue-200 text-blue-800',
                        success: 'bg-green-50 border border-green-200 text-green-800',
                        error: 'bg-red-50 border border-red-200 text-red-800',
                        warning: 'bg-yellow-50 border border-yellow-200 text-yellow-800'
                    };
                    return classes[type] || classes.info;
                }
            }
        }

        // Initialize on page load
        document.addEventListener('alpine:init', () => {
            Alpine.data('smartSearch', smartSearch);
        });

        function trackCategoryClick(categoryName) {
            // Simpan category click ke localStorage untuk personalization
            const categoryHistory = JSON.parse(localStorage.getItem('categoryHistory') || '[]');

            // Add to history
            categoryHistory.unshift({
                category: categoryName,
                timestamp: new Date().toISOString()
            });

            // Keep only last 10 items
            if (categoryHistory.length > 10) {
                categoryHistory.pop();
            }

            localStorage.setItem('categoryHistory', JSON.stringify(categoryHistory));

            // Optional: Send to analytics endpoint
            if (window.gtag) {
                gtag('event', 'select_category', {
                    'event_category': 'engagement',
                    'event_label': categoryName
                });
            }
        }

        // Function untuk category card animation
        function initCategoryCards() {
            const categoryCards = document.querySelectorAll('.category-card');

            categoryCards.forEach(card => {
                // Add click animation
                card.addEventListener('click', function(e) {
                    // Create ripple effect
                    const ripple = document.createElement('span');
                    const rect = this.getBoundingClientRect();
                    const size = Math.max(rect.width, rect.height);
                    const x = e.clientX - rect.left - size / 2;
                    const y = e.clientY - rect.top - size / 2;

                    ripple.style.cssText = `
                        position: absolute;
                        border-radius: 50%;
                        background: rgba(34, 197, 94, 0.2);
                        transform: scale(0);
                        animation: ripple 0.6s linear;
                        width: ${size}px;
                        height: ${size}px;
                        top: ${y}px;
                        left: ${x}px;
                        pointer-events: none;
                        z-index: 1;
                    `;

                    this.appendChild(ripple);

                    // Remove ripple after animation
                    setTimeout(() => {
                        ripple.remove();
                    }, 600);
                });

                // Hover effect untuk touch devices
                card.addEventListener('touchstart', function() {
                    this.classList.add('touch-active');
                });

                card.addEventListener('touchend', function() {
                    this.classList.remove('touch-active');
                });
            });
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            initCategoryCards();

            // Add data-section untuk tracking
            const categorySection = document.querySelector('section.bg-gray-50');
            if (categorySection) {
                categorySection.setAttribute('data-section', 'categories-exploration');
            }
        });

        // Add CSS untuk ripple animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes ripple {
                to {
                    transform: scale(4);
                    opacity: 0;
                }
            }

            .category-card {
                position: relative;
                overflow: hidden;
            }

            .category-card.touch-active {
                transform: scale(0.98);
                transition: transform 0.1s ease;
            }

            /* Enhanced hover effects for category cards */
            .category-card::after {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                border-radius: 20px;
                box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
                opacity: 0;
                transition: opacity 0.3s ease;
                pointer-events: none;
            }

            .category-card:hover::after {
                opacity: 1;
            }

            /* Mobile optimization */
            @media (max-width: 768px) {
                .categories-grid {
                    grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
                    gap: 16px;
                }

                .category-card {
                    padding: 20px 16px;
                }

                .category-icon {
                    width: 70px;
                    height: 70px;
                    margin-bottom: 16px;
                }
            }

            /* Animation untuk icon floating */
            @keyframes float-gentle {
                0%, 100% { transform: translateY(0) rotate(0deg); }
                50% { transform: translateY(-8px) rotate(5deg); }
            }

            .category-card:hover .category-icon i {
                animation: float-gentle 2s ease-in-out infinite;
            }
        `;
        document.head.appendChild(style);


    </script>
</body>
</html>
