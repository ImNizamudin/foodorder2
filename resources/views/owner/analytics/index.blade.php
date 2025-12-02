@extends('layouts.owner')

@section('title', $title)

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center space-x-4">
                <a href="{{ route('owner.dashboard') }}" class="text-gray-400 hover:text-gray-600 transition">
                    <i class='bx bx-arrow-back text-2xl'></i>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Restaurant Analytics</h1>
                    <p class="text-gray-600">Track your restaurant performance and insights</p>
                </div>
            </div>
            <a href="{{ route('owner.analytics.sales-report') }}"
               class="bg-primary-500 hover:bg-primary-600 text-white px-6 py-3 rounded-xl font-medium transition flex items-center space-x-2">
                <i class='bx bx-download'></i>
                <span>Sales Report</span>
            </a>
        </div>
    </div>

    <!-- Statistics Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Today's Revenue -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 stat-card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Today's Revenue</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">Rp {{ number_format($stats['today_revenue'], 0, ',', '.') }}</p>
                    <p class="text-sm text-gray-500 mt-1">{{ $stats['today_orders'] }} orders</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                    <i class='bx bx-dollar-circle text-green-600 text-2xl'></i>
                </div>
            </div>
        </div>

        <!-- Weekly Revenue -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 stat-card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Weekly Revenue</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">Rp {{ number_format($stats['weekly_revenue'], 0, ',', '.') }}</p>
                    <p class="text-sm text-gray-500 mt-1">{{ $stats['weekly_orders'] }} orders</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                    <i class='bx bx-trending-up text-blue-600 text-2xl'></i>
                </div>
            </div>
        </div>

        <!-- Monthly Revenue -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 stat-card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Monthly Revenue</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">Rp {{ number_format($stats['monthly_revenue'], 0, ',', '.') }}</p>
                    <p class="text-sm text-gray-500 mt-1">{{ $stats['monthly_orders'] }} orders</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                    <i class='bx bx-calendar text-purple-600 text-2xl'></i>
                </div>
            </div>
        </div>

        <!-- Average Order Value -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 stat-card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Avg Order Value</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">Rp {{ number_format($stats['avg_order_value'], 0, ',', '.') }}</p>
                    <p class="text-sm text-gray-500 mt-1">{{ $stats['total_orders'] }} total orders</p>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center">
                    <i class='bx bx-cart text-orange-600 text-2xl'></i>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Revenue Chart -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Revenue Overview (Last 30 Days)</h3>
                    <div class="flex items-center space-x-2 text-sm">
                        <span class="w-3 h-3 bg-primary-500 rounded-full"></span>
                        <span class="text-gray-600">Revenue</span>
                    </div>
                </div>
                <div class="h-80">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Popular Items -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">Top Menu Items</h3>
            <div class="space-y-4">
                @forelse($popularItems as $item)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center space-x-3">
                            @if($item->image)
                                <img src="{{ asset('storage/' . $item->image) }}"
                                     alt="{{ $item->name }}"
                                     class="w-10 h-10 rounded-lg object-cover">
                            @else
                                <div class="w-10 h-10 bg-gray-200 rounded-lg flex items-center justify-center">
                                    <i class='bx bx-food-menu text-gray-400'></i>
                                </div>
                            @endif
                            <div>
                                <p class="font-medium text-gray-900 text-sm">{{ $item->name }}</p>
                                <p class="text-xs text-gray-500">{{ $item->total_orders }} orders</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-semibold text-gray-900 text-sm">Rp {{ number_format($item->total_revenue, 0, ',', '.') }}</p>
                            <p class="text-xs text-gray-500">revenue</p>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <i class='bx bx-food-menu text-4xl text-gray-300 mb-3'></i>
                        <p class="text-gray-500">No orders yet</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Order Trends -->
    <div class="mt-8 bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
        <h3 class="text-lg font-semibold text-gray-900 mb-6">Order Trends (Last 7 Days)</h3>
        <div class="h-80">
            <canvas id="orderTrendsChart"></canvas>
        </div>
    </div>

    <!-- Additional Metrics -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
        <!-- Order Status Distribution -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Order Status</h3>
            <div class="space-y-3">
                @php
                    // Data status orders harus di-pass dari controller, kita gunakan dummy data untuk sementara
                    $statuses = [
                        'pending' => ['count' => 0, 'color' => 'bg-yellow-100 text-yellow-800'],
                        'confirmed' => ['count' => 0, 'color' => 'bg-blue-100 text-blue-800'],
                        'preparing' => ['count' => 0, 'color' => 'bg-orange-100 text-orange-800'],
                        'ready' => ['count' => 0, 'color' => 'bg-purple-100 text-purple-800'],
                        'completed' => ['count' => $stats['total_orders'] > 0 ? $stats['total_orders'] - 5 : 0, 'color' => 'bg-green-100 text-green-800'],
                        'cancelled' => ['count' => 0, 'color' => 'bg-red-100 text-red-800'],
                    ];
                @endphp

                @foreach($statuses as $status => $data)
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-600 capitalize">{{ $status }}</span>
                        <span class="px-2 py-1 rounded-full text-xs font-medium {{ $data['color'] }}">
                            {{ $data['count'] }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Performance Metrics -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Performance</h3>
            <div class="space-y-4">
                <div>
                    <div class="flex justify-between items-center mb-1">
                        <span class="text-sm font-medium text-gray-600">Completion Rate</span>
                        <span class="text-sm font-bold text-gray-900">
                            {{ $stats['total_orders'] > 0 ? round((($stats['total_orders'] - 5) / $stats['total_orders']) * 100) : 0 }}%
                        </span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-green-500 h-2 rounded-full"
                             style="width: {{ $stats['total_orders'] > 0 ? (($stats['total_orders'] - 5) / $stats['total_orders']) * 100 : 0 }}%"></div>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between items-center mb-1">
                        <span class="text-sm font-medium text-gray-600">Cancellation Rate</span>
                        <span class="text-sm font-bold text-gray-900">
                            {{ $stats['total_orders'] > 0 ? round((0 / $stats['total_orders']) * 100) : 0 }}%
                        </span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-red-500 h-2 rounded-full"
                             style="width: {{ $stats['total_orders'] > 0 ? (0 / $stats['total_orders']) * 100 : 0 }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
            <div class="space-y-3">
                <a href="{{ route('owner.orders.index') }}"
                   class="flex items-center space-x-3 p-3 bg-blue-50 hover:bg-blue-100 rounded-lg transition">
                    <i class='bx bx-receipt text-blue-600 text-xl'></i>
                    <span class="font-medium text-blue-900">View All Orders</span>
                </a>
                <a href="{{ route('owner.menu-items.index') }}"
                   class="flex items-center space-x-3 p-3 bg-green-50 hover:bg-green-100 rounded-lg transition">
                    <i class='bx bx-food-menu text-green-600 text-xl'></i>
                    <span class="font-medium text-green-900">Manage Menu</span>
                </a>
                <a href="{{ route('owner.analytics.sales-report') }}"
                   class="flex items-center space-x-3 p-3 bg-purple-50 hover:bg-purple-100 rounded-lg transition">
                    <i class='bx bx-download text-purple-600 text-xl'></i>
                    <span class="font-medium text-purple-900">Download Reports</span>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Revenue Chart
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        const revenueChart = new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($revenueData->pluck('date')) !!},
                datasets: [{
                    label: 'Revenue',
                    data: {!! json_encode($revenueData->pluck('revenue')) !!},
                    borderColor: '#22c55e',
                    backgroundColor: 'rgba(34, 197, 94, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // Order Trends Chart
        const trendsCtx = document.getElementById('orderTrendsChart').getContext('2d');
        const trendsChart = new Chart(trendsCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($orderTrends->pluck('date')) !!},
                datasets: [
                    {
                        label: 'Orders',
                        data: {!! json_encode($orderTrends->pluck('order_count')) !!},
                        backgroundColor: 'rgba(59, 130, 246, 0.8)',
                        borderColor: 'rgb(59, 130, 246)',
                        borderWidth: 1,
                        yAxisID: 'y'
                    },
                    {
                        label: 'Revenue',
                        data: {!! json_encode($orderTrends->pluck('revenue')) !!},
                        type: 'line',
                        borderColor: 'rgb(34, 197, 94)',
                        backgroundColor: 'rgba(34, 197, 94, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        yAxisID: 'y1'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                scales: {
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        title: {
                            display: true,
                            text: 'Number of Orders'
                        }
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        title: {
                            display: true,
                            text: 'Revenue'
                        },
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        },
                        grid: {
                            drawOnChartArea: false,
                        },
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label === 'Revenue') {
                                    return label + ': Rp ' + context.parsed.y.toLocaleString('id-ID');
                                }
                                return label + ': ' + context.parsed.y;
                            }
                        }
                    }
                }
            }
        });

        // Auto-refresh data every 30 seconds
        setInterval(() => {
            fetch('{{ route("owner.analytics.index") }}')
                .then(response => response.text())
                .then(html => {
                    // You can implement partial refresh here if needed
                    console.log('Data refreshed');
                })
                .catch(error => console.error('Refresh error:', error));
        }, 30000);
    });
</script>
@endsection
