@extends('layouts.admin')

@section('title', 'User Management')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">User Management</h1>
            <p class="text-gray-600">Manage all users on the platform</p>
        </div>
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.users.create') }}"
            class="bg-primary-500 hover:bg-primary-600 text-white px-6 py-3 rounded-xl font-medium transition flex items-center space-x-2">
                <i class='bx bx-plus'></i>
                <span>Add User</span>
            </a>
            <div class="bg-white px-4 py-2 rounded-xl border border-gray-200">
                <p class="text-sm text-gray-600">Total Users</p>
                <p class="text-lg font-semibold text-center text-gray-900">{{ $users->total() }}</p>
            </div>
        </div>
    </div>

    <!-- User Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Customers</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">
                        {{ $users->where('role', 'customer')->count() }}
                    </p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-2xl flex items-center justify-center">
                    <i class='bx bx-user text-2xl text-blue-600'></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Restaurant Owners</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">
                        {{ $users->where('role', 'owner')->count() }}
                    </p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-2xl flex items-center justify-center">
                    <i class='bx bx-store-alt text-2xl text-green-600'></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Admins</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">
                        {{ $users->where('role', 'admin')->count() }}
                    </p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-2xl flex items-center justify-center">
                    <i class='bx bx-shield-alt text-2xl text-purple-600'></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Total Users</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">
                        {{ $users->total() }}
                    </p>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-2xl flex items-center justify-center">
                    <i class='bx bx-line-chart text-2xl text-orange-600'></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
        <div class="p-6 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-900">All Users</h2>
                <div class="flex items-center space-x-3">
                    <input type="text" placeholder="Search users..."
                           class="px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-primary-300">
                    <button class="bg-primary-500 hover:bg-primary-600 text-white px-4 py-2 rounded-lg font-medium transition">
                        <i class='bx bx-filter mr-2'></i>Filter
                    </button>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Joined</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @foreach($users as $user)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-gradient-to-r from-primary-500 to-primary-600 rounded-full flex items-center justify-center">
                                    <span class="text-white font-semibold text-sm">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </span>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($user->role === 'admin')
                                <span class="px-2 py-1 bg-purple-100 text-purple-800 text-xs rounded-full font-medium">Admin</span>
                            @elseif($user->role === 'owner')
                                <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full font-medium">Owner</span>
                            @else
                                <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full font-medium">Customer</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $user->created_at->format('M j, Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full font-medium">Active</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('admin.users.show', $user) }}"
                                class="text-primary-600 hover:text-primary-900 transition" title="View Details">
                                    <i class='bx bx-show text-lg'></i>
                                </a>

                                <!-- Delete Form -->
                                @if($user->id !== auth()->id())
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="text-red-600 hover:text-red-900 transition"
                                            title="Delete User"
                                            onclick="return confirm('Are you sure you want to delete this user?')">
                                        <i class='bx bx-trash text-lg'></i>
                                    </button>
                                </form>
                                @else
                                <span class="text-gray-400 cursor-not-allowed" title="Cannot delete your own account">
                                    <i class='bx bx-trash text-lg'></i>
                                </span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection
