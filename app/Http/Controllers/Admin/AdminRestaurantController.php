<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Http\Request;


class AdminRestaurantController extends Controller
{
    public function index()
    {
        $restaurants = Restaurant::with('user')->latest()->paginate(10);

        return view('admin.restaurants.index', [
            'title' => 'Restaurant Management',
            'restaurants' => $restaurants
        ]);
    }

    public function show(Restaurant $restaurant)
    {
        $restaurant->load(['user', 'menuItems']);

        return view('admin.restaurants.show', [
            'title' => 'Restaurant Details - ' . $restaurant->name,
            'restaurant' => $restaurant
        ]);
    }

    public function create()
    {
        $owners = User::where('role', 'owner')->get();

        return view('admin.restaurants.create', [
            'title' => 'Add New Restaurant',
            'owners' => $owners
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'address' => ['required', 'string'],
            'phone' => ['required', 'string', 'max:15'],
            'email' => ['nullable', 'email'],
            'user_id' => ['required', 'exists:users,id'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        Restaurant::create([
            'name' => $request->name,
            'description' => $request->description,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            'user_id' => $request->user_id,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.restaurants')->with('success', 'Restaurant created successfully.');
    }

    public function updateStatus(Request $request, Restaurant $restaurant)
    {
        $request->validate([
            'status' => ['required', 'in:active,inactive']
        ]);

        $restaurant->update([
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'Restaurant status updated successfully.');
    }

    public function destroy(Restaurant $restaurant)
    {
        $restaurant->delete();

        return redirect()->route('admin.restaurants')->with('success', 'Restaurant deleted successfully.');
    }
}
