<?php

use App\Http\Controllers\Customer\HomeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Search suggestions API
Route::get('/search-suggestions', [HomeController::class, 'searchSuggestions']);
