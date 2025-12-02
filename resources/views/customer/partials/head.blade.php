<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $title ?? 'FoodOrder - Order Makanan Online' }}</title>

<!-- Poppins Font -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<!-- Box Icons -->
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

<!-- Flaticon -->
<link rel="stylesheet" href="https://cdn-uicons.flaticon.com/2.1.0/uicons-regular-straight/css/uicons-regular-straight.css">
<link rel="stylesheet" href="https://cdn-uicons.flaticon.com/2.1.0/uicons-solid-straight/css/uicons-solid-straight.css">
<link rel="stylesheet" href="https://cdn-uicons.flaticon.com/2.1.0/uicons-brands/css/uicons-brands.css">

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
        background-color: #ffffff;
    }

    .restaurant-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .restaurant-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
    }

    .category-btn {
        transition: all 0.2s ease;
    }

    .category-btn.active {
        background: #22c55e;
        color: white;
    }

    .food-card {
        transition: all 0.2s ease;
    }

    .food-card:hover {
        transform: scale(1.02);
    }

    .user-dropdown {
        transition: all 0.2s ease;
    }

    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .sticky-nav {
        position: sticky;
        top: 64px;
        z-index: 40;
        background: white;
    }

    .category-tab.active {
        border-bottom: 3px solid #22c55e;
        color: #22c55e;
        font-weight: 600;
    }

    /* Flaticon Icon Styles */
    .flaticon-icon {
        font-size: 1.5rem;
    }

    /* Enhanced Category Cards with Flaticon */
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
</style>
