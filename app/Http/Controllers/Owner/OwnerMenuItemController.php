<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use App\Models\Restaurant;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OwnerMenuItemController extends Controller
{
    public function index()
    {
        $restaurant = Restaurant::where('user_id', Auth::id())->firstOrFail();
        $menuItems = MenuItem::with('category')
            ->where('restaurant_id', $restaurant->id)
            ->latest()
            ->paginate(10);

        $categories = Category::where('is_active', true)->get();

        return view('owner.menu-items.index', [
            'title' => 'Menu Management',
            'menuItems' => $menuItems,
            'categories' => $categories,
            'restaurant' => $restaurant
        ]);
    }

    public function create()
    {
        $restaurant = Restaurant::where('user_id', Auth::id())->firstOrFail();
        $categories = Category::where('is_active', true)->get();

        return view('owner.menu-items.create', [
            'title' => 'Add Menu Item',
            'categories' => $categories,
            'restaurant' => $restaurant
        ]);
    }

    public function store(Request $request)
    {
        $restaurant = Restaurant::where('user_id', Auth::id())->firstOrFail();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:1000'],
            'category_id' => ['required', 'exists:categories,id'],
            'is_available' => ['required', 'boolean'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'], // 2MB max
        ]);

        try {
            // Handle checkbox value
            $isAvailable = $request->boolean('is_available');

            $menuItemData = [
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'category_id' => $request->category_id,
                'is_available' => $isAvailable,
                'restaurant_id' => $restaurant->id,
            ];

            // ✅ HANDLE IMAGE UPLOAD
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('menu-items', 'public');
                $menuItemData['image'] = $imagePath;
            }

            MenuItem::create($menuItemData);

            return redirect()->route('owner.menu-items.index')
                ->with('success', '✅ Menu item created successfully!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', '❌ Failed to create menu item: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit(MenuItem $menuItem)
    {
        // Verify ownership
        $restaurant = Restaurant::where('user_id', Auth::id())->firstOrFail();
        if ($menuItem->restaurant_id !== $restaurant->id) {
            abort(403, 'Unauthorized action.');
        }

        $categories = Category::where('is_active', true)->get();

        return view('owner.menu-items.edit', [
            'title' => 'Edit Menu Item',
            'menuItem' => $menuItem,
            'categories' => $categories,
            'restaurant' => $restaurant
        ]);
    }

    public function update(Request $request, MenuItem $menuItem)
    {
        // Verify ownership
        $restaurant = Restaurant::where('user_id', Auth::id())->firstOrFail();
        if ($menuItem->restaurant_id !== $restaurant->id) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:1000'],
            'category_id' => ['required', 'exists:categories,id'],
            'is_available' => ['required', 'boolean'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ]);

        try {
            $updateData = [
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'category_id' => $request->category_id,
                'is_available' => $request->boolean('is_available'),
            ];

            // ✅ HANDLE IMAGE UPLOAD/REMOVAL
            if ($request->has('remove_image') && $request->boolean('remove_image')) {
                // Remove existing image
                if ($menuItem->image) {
                    Storage::disk('public')->delete($menuItem->image);
                    $updateData['image'] = null;
                }
            } elseif ($request->hasFile('image')) {
                // Upload new image
                if ($menuItem->image) {
                    Storage::disk('public')->delete($menuItem->image);
                }
                $imagePath = $request->file('image')->store('menu-items', 'public');
                $updateData['image'] = $imagePath;
            }

            $menuItem->update($updateData);

            return redirect()->route('owner.menu-items.index')
                ->with('success', '✅ Menu item updated successfully!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', '❌ Failed to update menu item: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(MenuItem $menuItem)
    {
        // Verify ownership
        $restaurant = Restaurant::where('user_id', Auth::id())->firstOrFail();
        if ($menuItem->restaurant_id !== $restaurant->id) {
            abort(403, 'Unauthorized action.');
        }

        try {
            // Delete image if exists
            if ($menuItem->image) {
                Storage::disk('public')->delete($menuItem->image);
            }

            $menuItem->delete();

            return redirect()->route('owner.menu-items.index')
                ->with('success', '✅ Menu item deleted successfully!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', '❌ Failed to delete menu item: ' . $e->getMessage());
        }
    }

    public function toggleAvailability(MenuItem $menuItem)
    {
        // Verify ownership
        $restaurant = Restaurant::where('user_id', Auth::id())->firstOrFail();
        if ($menuItem->restaurant_id !== $restaurant->id) {
            abort(403, 'Unauthorized action.');
        }

        $menuItem->update([
            'is_available' => !$menuItem->is_available
        ]);

        $status = $menuItem->is_available ? 'available' : 'unavailable';
        return redirect()->back()->with('success', "✅ Menu item marked as {$status}!");
    }
}
