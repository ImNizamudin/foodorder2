<?php

use App\Http\Controllers\Admin\AdminAnalyticsController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminRestaurantController;
use App\Http\Controllers\Admin\AdminSettingController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Customer\CustomerCartController;
use App\Http\Controllers\Customer\CustomerOrderController;
use App\Http\Controllers\Customer\CustomerRestaurantController;
use App\Http\Controllers\Owner\DashboardController as OwnerDashboard;
use App\Http\Controllers\Customer\HomeController;
use App\Http\Controllers\HomeController as ControllersHomeController;
use App\Http\Controllers\Owner\OwnerAnalyticsController;
use App\Http\Controllers\Owner\OwnerMenuItemController;
use App\Http\Controllers\Owner\OwnerOrderController;
use App\Http\Controllers\Owner\OwnerRestaurantController;

// guest
Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

// Public routes - hanya untuk guest (belum login)
Route::middleware(['guest'])->group(function () {
    Route::get('/', function () {
        return view('customer.landing');
    });
});

// Admin Routes
Route::prefix('admin')->middleware(['auth', 'check.admin'])->group(function() {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('admin.dashboard');

    // user management
    Route::get('/users', [AdminUserController::class, 'index'])->name('admin.users');
    Route::get('/users/create', [AdminUserController::class, 'create'])->name('admin.users.create');
    Route::post('/users', [AdminUserController::class, 'store'])->name('admin.users.store');
    Route::get('/users/{user}', [AdminUserController::class, 'show'])->name('admin.users.show');
    Route::put('/users/{user}', [AdminUserController::class, 'update'])->name('admin.users.update');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');

    // restaurant management
    Route::get('/restaurants', [AdminRestaurantController::class, 'index'])->name('admin.restaurants');
    Route::get('/restaurants/create', [AdminRestaurantController::class, 'create'])->name('admin.restaurants.create');
    Route::post('/restaurants', [AdminRestaurantController::class, 'store'])->name('admin.restaurants.store');
    Route::get('/restaurants/{restaurant}', [AdminRestaurantController::class, 'show'])->name('admin.restaurants.show');
    Route::put('/restaurants/{restaurant}/status', [AdminRestaurantController::class, 'updateStatus'])->name('admin.restaurants.status');
    Route::delete('/restaurants/{restaurant}', [AdminRestaurantController::class, 'destroy'])->name('admin.restaurants.destroy');

    Route::get('/orders', [AdminOrderController::class, 'index'])->name('admin.orders');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('admin.orders.show');
    Route::put('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('admin.orders.status');
    Route::delete('/orders/{order}', [AdminOrderController::class, 'destroy'])->name('admin.orders.destroy');

    // Orders & Analytics
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('admin.orders');
    Route::get('/analytics', [AdminAnalyticsController::class, 'index'])->name('admin.analytics');

    // System Settings
    Route::get('/settings', [AdminSettingController::class, 'index'])->name('admin.settings');
    Route::put('/settings', [AdminSettingController::class, 'update'])->name('admin.settings.update');
});

// Owner Routes
// Restaurant Owner Routes - hanya bisa diakses oleh owner
Route::prefix('owner')->middleware(['auth', 'check.owner'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [OwnerDashboard::class, 'index'])->name('owner.dashboard');

    // Restaurant Management
    Route::get('/restaurant/create', [OwnerRestaurantController::class, 'create'])->name('owner.restaurants.create');
    Route::post('/restaurant', [OwnerRestaurantController::class, 'store'])->name('owner.restaurants.store');
    Route::get('/restaurant/edit', [OwnerRestaurantController::class, 'edit'])->name('owner.restaurants.edit');
    Route::put('/restaurant', [OwnerRestaurantController::class, 'update'])->name('owner.restaurants.update');
    Route::post('/owner/restaurants/toggle-status', [OwnerRestaurantController::class, 'toggleStatus'])->name('owner.restaurants.toggle-status');

    // Menu Management
    // Menu Management Routes
    Route::get('/menu-items', [OwnerMenuItemController::class, 'index'])->name('owner.menu-items.index');
    Route::get('/menu-items/create', [OwnerMenuItemController::class, 'create'])->name('owner.menu-items.create');
    Route::post('/menu-items', [OwnerMenuItemController::class, 'store'])->name('owner.menu-items.store');
    Route::get('/menu-items/{menuItem}/edit', [OwnerMenuItemController::class, 'edit'])->name('owner.menu-items.edit');
    Route::put('/menu-items/{menuItem}', [OwnerMenuItemController::class, 'update'])->name('owner.menu-items.update');
    Route::delete('/menu-items/{menuItem}', [OwnerMenuItemController::class, 'destroy'])->name('owner.menu-items.destroy');
    Route::patch('/menu-items/{menuItem}/toggle-availability', [OwnerMenuItemController::class, 'toggleAvailability'])->name('owner.menu-items.toggle-availability');

    // Order Management
    Route::get('/orders', [OwnerOrderController::class, 'index'])->name('owner.orders.index');
    Route::get('/orders/{order}', [OwnerOrderController::class, 'show'])->name('owner.orders.show');
    Route::put('/orders/{order}/status', [OwnerOrderController::class, 'updateStatus'])->name('owner.orders.status');
    Route::get('/orders/{order}/receipt', [OwnerOrderController::class, 'printReceipt'])->name('owner.orders.receipt');
    Route::get('/orders/analytics', [OwnerOrderController::class, 'analytics'])->name('owner.orders.analytics');

    // Analytics
    Route::get('/analytics', [OwnerAnalyticsController::class, 'index'])->name('owner.analytics.index');
    Route::get('/owner/analytics/sales-report', [OwnerAnalyticsController::class, 'salesReport'])->name('owner.analytics.sales-report');
});

// Customer Routes
Route::middleware(['auth', 'check.customer'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/profile', function () { return view('customer.profile', ['title' => 'My Profile']); })->name('customer.profile');


    Route::get('/restaurants', [CustomerRestaurantController::class, 'index'])->name('customer.restaurants');
    Route::get('/restaurants/{restaurant}', [CustomerRestaurantController::class, 'show'])->name('customer.restaurants.show');

    Route::get('/api/search-suggestions', [HomeController::class, 'searchSuggestions'])->name('api.search-suggestions');
    Route::get('/api/popular-suggestions', [HomeController::class, 'popularSearchSuggestions'])->name('api.popular-suggestions');

    Route::get('/cart', [CustomerCartController::class, 'index'])->name('customer.cart');
    Route::get('/cart/get', [CustomerCartController::class, 'getCart'])->name('customer.cart.get');
    Route::post('/cart/add', [CustomerCartController::class, 'addToCart'])->name('customer.cart.add');
    Route::post('/cart/update', [CustomerCartController::class, 'updateCart'])->name('customer.cart.update');
    Route::delete('/cart/remove/{menuItemId}', [CustomerCartController::class, 'removeFromCart'])->name('customer.cart.remove');
    Route::post('/cart/clear', [CustomerCartController::class, 'clearCart'])->name('customer.cart.clear');

    // Checkout Routes
    Route::get('/checkout', [CustomerCartController::class, 'checkout'])->name('customer.checkout');
    Route::post('/checkout/place', [CustomerCartController::class, 'placeOrder'])->name('customer.checkout.place');

    // Order Management
    Route::get('/orders', [CustomerOrderController::class, 'index'])->name('customer.orders.index');
    Route::get('/orders/{order}', [CustomerOrderController::class, 'show'])->name('customer.orders.show');
    Route::get('/orders/{order}/confirmation', [CustomerOrderController::class, 'confirmation'])->name('customer.orders.confirmation');
    Route::get('/orders/{order}/track', [CustomerOrderController::class, 'track'])->name('customer.orders.track');
    Route::post('/orders/{order}/cancel', [CustomerOrderController::class, 'cancel'])->name('customer.orders.cancel');
    Route::post('/orders/{order}/reorder', [CustomerOrderController::class, 'reorder'])->name('customer.orders.reorder');
    Route::post('/orders/{order}/review', [CustomerOrderController::class, 'addReview'])->name('customer.orders.review');
});

require __DIR__.'/auth.php';
