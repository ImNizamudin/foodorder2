@extends('layouts.owner')

@section('title', $title)

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center space-x-4 mb-4">
            <a href="{{ route('owner.analytics.index') }}" class="text-gray-400 hover:text-gray-600 transition">
                <i class='bx bx-arrow-back text-2xl'></i>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Sales Report</h1>
                <p class="text-gray-600">Detailed sales analysis and reporting</p>
            </div>
        </div>
    </div>

    <!-- Date Filter -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 mb-6">
        <form method="GET" class="flex flex-col md:flex-row gap-4 items-end">
            <div class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">Start Date</label>
                    <input type="date" id="start_date" name="start_date" value="{{ $report['start_date'] }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-primary-500">
                </div>
                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2">End Date</label>
                    <input type="date" id="end_date" name="end_date" value="{{ $report['end_date'] }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-primary-500">
                </div>
            </div>
            <div class="flex space-x-3">
                <button type="submit"
                        class="bg-primary-500 hover:bg-primary-600 text-white px-6 py-2 rounded-lg font-medium transition flex items-center space-x-2">
                    <i class='bx bx-filter'></i>
                    <span>Apply Filter</span>
                </button>
                <a href="{{ route('owner.analytics.sales-report') }}"
                   class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Report Summary -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="text-center">
                <p class="text-sm font-medium text-gray-600">Total Orders</p>
                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $report['total_orders'] }}</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="text-center">
                <p class="text-sm font-medium text-gray-600">Total Revenue</p>
                <p class="text-3xl font-bold text-gray-900 mt-2">Rp {{ number_format($report['total_revenue'], 0, ',', '.') }}</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="text-center">
                <p class="text-sm font-medium text-gray-600">Average Order Value</p>
                <p class="text-3xl font-bold text-gray-900 mt-2">Rp {{ number_format($report['average_order_value'], 0, ',', '.') }}</p>
            </div>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
        <div class="p-6 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900">Order Details</h3>
            <p class="text-sm text-gray-600 mt-1">Period: {{ $report['start_date'] }} to {{ $report['end_date'] }}</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Items</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($report['orders'] as $order)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#{{ $order->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $order->created_at->format('M j, Y H:i') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $order->customer_name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $order->orderItems->count() }} items
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs rounded-full font-medium capitalize
                                    @if($order->status === 'completed') bg-green-100 text-green-800
                                    @elseif($order->status === 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($order->status === 'cancelled') bg-red-100 text-red-800
                                    @else bg-blue-100 text-blue-800 @endif">
                                    {{ $order->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                <i class='bx bx-receipt text-4xl text-gray-300 mb-3'></i>
                                <p>No orders found for the selected period</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Export Options -->
        <div class="p-6 border-t border-gray-100">
            <div class="flex justify-between items-center">
                <p class="text-sm text-gray-600">
                    Showing {{ $report['orders']->count() }} orders
                </p>
                <div class="flex space-x-3">
                    <button onclick="window.print()"
                            class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium flex items-center space-x-2">
                        <i class='bx bx-printer'></i>
                        <span>Print Report</span>
                    </button>
                    <button onclick="exportToPDF()"
                            class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg font-medium transition flex items-center space-x-2">
                        <i class='bx bx-file'></i>
                        <span>Export PDF</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function exportToPDF() {
        // Simple PDF export simulation
        alert('PDF export functionality would be implemented here with a library like jsPDF');
        // In a real implementation, you would use jsPDF or make an API call to generate PDF
    }

    // Auto-set end date to today and start date to 30 days ago by default
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        if (!urlParams.has('start_date') && !urlParams.has('end_date')) {
            const today = new Date().toISOString().split('T')[0];
            const thirtyDaysAgo = new Date();
            thirtyDaysAgo.setDate(thirtyDaysAgo.getDate() - 30);
            const thirtyDaysAgoStr = thirtyDaysAgo.toISOString().split('T')[0];

            document.getElementById('start_date').value = thirtyDaysAgoStr;
            document.getElementById('end_date').value = today;
        }
    });
</script>

<style>
    @media print {
        .bg-white {
            background: white !important;
        }
        .shadow-sm {
            box-shadow: none !important;
        }
        .border {
            border: 1px solid #e5e7eb !important;
        }
    }
</style>
@endsection
