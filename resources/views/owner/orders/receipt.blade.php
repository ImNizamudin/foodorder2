<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt - {{ $order->order_number }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        @media print {
            body {
                -webkit-print-color-adjust: exact;
                margin: 0;
                padding: 0;
            }
            .no-print { display: none !important; }
            .receipt-container {
                box-shadow: none !important;
                border: none !important;
                margin: 0 !important;
                padding: 0 !important;
            }
        }

        body {
            font-family: 'Courier New', monospace;
        }

        .receipt-container {
            max-width: 80mm;
            margin: 0 auto;
            background: white;
        }
    </style>
</head>
<body class="bg-gray-100 p-4">
    <!-- Print Controls -->
    <div class="no-print fixed top-4 right-4 z-50">
        <div class="bg-white rounded-lg shadow-lg p-4 space-y-2">
            <button onclick="window.print()" class="w-full bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded flex items-center justify-center space-x-2">
                <i class='bx bx-printer'></i>
                <span>Print Receipt</span>
            </button>
            <button onclick="window.close()" class="w-full bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded flex items-center justify-center space-x-2">
                <i class='bx bx-x'></i>
                <span>Close</span>
            </button>
        </div>
    </div>

    <!-- Receipt Content -->
    <div class="receipt-container bg-white shadow-lg rounded-lg p-6">
        <!-- Header -->
        <div class="text-center border-b-2 border-dashed border-gray-300 pb-4 mb-4">
            <h1 class="text-2xl font-bold text-gray-900">{{ $restaurant->name }}</h1>
            <p class="text-gray-600 text-sm">{{ $restaurant->address }}</p>
            <p class="text-gray-600 text-sm">Tel: {{ $restaurant->phone }}</p>
        </div>

        <!-- Order Info -->
        <div class="mb-4">
            <div class="flex justify-between items-start mb-2">
                <div>
                    <p class="font-semibold">Order: {{ $order->order_number }}</p>
                    <p class="text-sm text-gray-600">{{ $order->created_at->format('M j, Y H:i') }}</p>
                </div>
                <div class="text-right">
                    <span class="px-2 py-1 rounded text-xs font-medium
                        @if($order->status == 'completed') bg-green-100 text-green-800
                        @elseif($order->status == 'preparing') bg-orange-100 text-orange-800
                        @elseif($order->status == 'ready') bg-blue-100 text-blue-800
                        @else bg-gray-100 text-gray-800 @endif">
                        {{ strtoupper($order->status) }}
                    </span>
                </div>
            </div>

            <div class="text-sm">
                <p><strong>Customer:</strong> {{ $order->user->name }}</p>
                @if($order->user->phone)
                <p><strong>Phone:</strong> {{ $order->user->phone }}</p>
                @endif
                @if($order->delivery_address)
                <p><strong>Address:</strong> {{ $order->delivery_address }}</p>
                @endif
                <p><strong>Type:</strong> {{ $order->order_type === 'delivery' ? 'Delivery' : 'Pickup' }}</p>
            </div>
        </div>

        <!-- Order Items -->
        <div class="border-y border-dashed border-gray-300 py-4 mb-4">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="text-left pb-2">Item</th>
                        <th class="text-right pb-2">Qty</th>
                        <th class="text-right pb-2">Price</th>
                        <th class="text-right pb-2">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->orderItems as $item)
                    <tr class="border-b border-gray-100">
                        <td class="py-2">
                            <div>
                                <p class="font-medium">{{ $item->menuItem->name }}</p>
                                @if($item->special_instructions)
                                <p class="text-xs text-gray-600 italic">- {{ $item->special_instructions }}</p>
                                @endif
                            </div>
                        </td>
                        <td class="text-right py-2">{{ $item->quantity }}</td>
                        <td class="text-right py-2">Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                        <td class="text-right py-2 font-medium">Rp {{ number_format($item->unit_price * $item->quantity, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Order Summary -->
        <div class="mb-4">
            <div class="space-y-1 text-sm">
                <div class="flex justify-between">
                    <span>Subtotal:</span>
                    <span>Rp {{ number_format($order->total_amount - $order->tax_amount - $order->delivery_fee, 0, ',', '.') }}</span>
                </div>

                @if($order->tax_amount > 0)
                <div class="flex justify-between">
                    <span>Tax ({{ $order->tax_rate ?? 10 }}%):</span>
                    <span>Rp {{ number_format($order->tax_amount, 0, ',', '.') }}</span>
                </div>
                @endif

                @if($order->delivery_fee > 0)
                <div class="flex justify-between">
                    <span>Delivery Fee:</span>
                    <span>Rp {{ number_format($order->delivery_fee, 0, ',', '.') }}</span>
                </div>
                @endif

                <div class="flex justify-between border-t border-gray-300 pt-2 mt-2 font-bold text-lg">
                    <span>TOTAL:</span>
                    <span>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Payment Info -->
        <div class="border-t border-dashed border-gray-300 pt-4 mb-4">
            <div class="text-sm">
                <p><strong>Payment Method:</strong> {{ ucfirst($order->payment_method ?? 'Cash') }}</p>
                <p><strong>Order #:</strong> {{ $order->order_number }}</p>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center border-t-2 border-dashed border-gray-300 pt-4">
            <p class="text-sm text-gray-600 mb-2">Thank you for your order!</p>
            <p class="text-xs text-gray-500">{{ $restaurant->name }}</p>
            <p class="text-xs text-gray-500">Printed: {{ now()->format('M j, Y H:i') }}</p>
        </div>

        <!-- Special Instructions -->
        @if($order->special_instructions)
        <div class="mt-4 p-3 bg-yellow-50 border border-yellow-200 rounded">
            <p class="text-sm font-semibold text-yellow-800">Special Instructions:</p>
            <p class="text-sm text-yellow-700">{{ $order->special_instructions }}</p>
        </div>
        @endif
    </div>

    <script>
        // Auto-print when page loads (optional)
        window.onload = function() {
            // Uncomment below line to auto-print when page loads
            // window.print();
        };

        // Add print styles
        const style = document.createElement('style');
        style.textContent = `
            @media print {
                @page {
                    margin: 0;
                    size: 80mm auto;
                }
                body {
                    margin: 0;
                    padding: 0;
                    background: white;
                    font-size: 12px;
                }
                .receipt-container {
                    width: 80mm;
                    margin: 0 auto;
                    padding: 10px;
                    box-shadow: none;
                    border: none;
                }
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>
