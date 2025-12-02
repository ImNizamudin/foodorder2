<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AdminUserController extends Controller
{
    public function index()
    {
        // $users = User::withCount(['orders'])->latest()->paginate(10);
        // $users = User::select('id', 'name', 'email', 'role', 'phone', 'created_at')
        //         ->latest()
        //         ->paginate(10);

        $users = User::paginate(10);

        return view('admin.users.index', [
            'title' => 'User Management',
            'users' => $users
        ]);
    }

    public function create()
    {
        return view('admin.users.create', [
            'title' => 'Add New User'
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phone' => ['required', 'string', 'max:15'],
            'role' => ['required', 'in:admin,owner,customer'],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'role' => $request->role,
        ]);

        return redirect()->route('admin.users')->with('success', 'User created successfully.');
    }

    public function show(User $user)
    {
        return view('admin.users.show', [
            'title' => 'User Details - ' . $user->name,
            'user' => $user
        ]);
    }

    public function destroy(User $user)
    {
        // Prevent admin from deleting themselves
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->route('admin.users')->with('success', 'User deleted successfully.');
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'role' => 'sometimes|in:admin,owner,customer',
            'status' => 'sometimes|in:active,suspended'
        ]);

        if ($request->has('role')) {
            $user->role = $request->role;
        }

        // Untuk status, kita bisa tambah kolom 'status' di users table nanti
        // $user->status = $request->status;

        $user->save();

        return redirect()->back()->with('success', 'User updated successfully.');
    }
}
