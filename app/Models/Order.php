<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'status',
        'total_amount',
        'subtotal',
        'delivery_fee',
        'tax_amount',
        'notes',
        'customer_name',
        'customer_phone',
        'customer_address',
        'user_id',
        'restaurant_id',
        'payment_method',
        'payment_status',
        'delivery_time',
        'ordered_at',
        'cancellation_reason',
        'customer_rating',
        'customer_review',
        'reviewed_at',
        'confirmed_at',
        'preparing_at',
        'ready_at',
        'on_the_way_at',
        'completed_at'
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'delivery_fee' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'ordered_at' => 'datetime',
        'confirmed_at' => 'datetime',
        'preparing_at' => 'datetime',
        'ready_at' => 'datetime',
        'on_the_way_at' => 'datetime',
        'completed_at' => 'datetime',
        'reviewed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getTotalItemsAttribute()
    {
        return $this->orderItems->sum('quantity');
    }

    // Accessor untuk formatted total amount
    public function getFormattedTotalAttribute()
    {
        return 'Rp ' . number_format($this->total_amount, 0, ',', '.');
    }

    public function getFormattedDeliveryFeeAttribute()
    {
        return 'Rp ' . number_format($this->delivery_fee, 0, ',', '.');
    }

    public function getFormattedTaxAmountAttribute()
    {
        return 'Rp ' . number_format($this->tax_amount, 0, ',', '.');
    }

    // Accessor untuk status badge color
    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'pending' => 'bg-yellow-100 text-yellow-800',
            'confirmed' => 'bg-blue-100 text-blue-800',
            'preparing' => 'bg-orange-100 text-orange-800',
            'ready' => 'bg-purple-100 text-purple-800',
            'on_the_way' => 'bg-indigo-100 text-indigo-800',
            'completed' => 'bg-green-100 text-green-800',
            'cancelled' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    public function getStatusTextAttribute()
    {
        return match($this->status) {
            'pending' => 'Order Placed',
            'confirmed' => 'Confirmed',
            'preparing' => 'Preparing Food',
            'ready' => 'Ready for Pickup',
            'on_the_way' => 'On the Way',
            'completed' => 'Delivered',
            'cancelled' => 'Cancelled',
            default => 'Unknown'
        };
    }

    public function getStatusIconAttribute()
    {
        return match($this->status) {
            'pending' => 'bx bx-time',
            'confirmed' => 'bx bx-check-circle',
            'preparing' => 'bx bx-bowl-hot',
            'ready' => 'bx bx-package',
            'on_the_way' => 'bx bx-bike',
            'completed' => 'bx bx-check-double',
            'cancelled' => 'bx bx-x-circle',
            default => 'bx bx-question-mark'
        };
    }

    // Payment method accessors
    public function getPaymentMethodTextAttribute()
    {
        return match($this->payment_method) {
            'cash' => 'Cash on Delivery',
            'card' => 'Credit/Debit Card',
            'digital_wallet' => 'Digital Wallet',
            default => 'Cash on Delivery'
        };
    }

    public function getPaymentMethodIconAttribute()
    {
        return match($this->payment_method) {
            'cash' => 'bx-money',
            'card' => 'bx-credit-card',
            'digital_wallet' => 'bx-wallet',
            default => 'bx-money'
        };
    }

    public function getPaymentStatusTextAttribute()
    {
        return match($this->payment_status) {
            'pending' => 'Pending',
            'paid' => 'Paid',
            'failed' => 'Failed',
            default => 'Pending'
        };
    }

    public function getPaymentStatusBadgeAttribute()
    {
        return match($this->payment_status) {
            'pending' => 'bg-yellow-100 text-yellow-800',
            'paid' => 'bg-green-100 text-green-800',
            'failed' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    // Delivery time accessor
    public function getDeliveryTimeTextAttribute()
    {
        return match($this->delivery_time) {
            'asap' => 'ASAP (25-35 min)',
            'schedule' => 'Scheduled Delivery',
            default => 'ASAP'
        };
    }

    // Estimated delivery time calculation
    public function getEstimatedDeliveryTimeAttribute()
    {
        if ($this->delivery_time === 'asap') {
            return $this->ordered_at ? $this->ordered_at->addMinutes(35) : now()->addMinutes(35);
        }

        return $this->ordered_at ? $this->ordered_at->addMinutes(45) : now()->addMinutes(45);
    }

    // Order timeline progress
    public function getTimelineAttribute()
    {
        $timeline = [
            'pending' => [
                'status' => 'Order Placed',
                'description' => 'We have received your order',
                'icon' => 'bx-check-circle',
                'active' => true,
                'completed' => true
            ],
            'confirmed' => [
                'status' => 'Order Confirmed',
                'description' => 'Restaurant has confirmed your order',
                'icon' => 'bx-restaurant',
                'active' => $this->status !== 'pending',
                'completed' => in_array($this->status, ['confirmed', 'preparing', 'ready', 'on_the_way', 'completed'])
            ],
            'preparing' => [
                'status' => 'Preparing Food',
                'description' => 'Restaurant is preparing your food',
                'icon' => 'bx-bowl-hot',
                'active' => in_array($this->status, ['preparing', 'ready', 'on_the_way', 'completed']),
                'completed' => in_array($this->status, ['ready', 'on_the_way', 'completed'])
            ],
            'ready' => [
                'status' => 'Ready for Delivery',
                'description' => 'Your food is ready and waiting for delivery',
                'icon' => 'bx-package',
                'active' => in_array($this->status, ['ready', 'on_the_way', 'completed']),
                'completed' => in_array($this->status, ['on_the_way', 'completed'])
            ],
            'on_the_way' => [
                'status' => 'On the Way',
                'description' => 'Driver is delivering your order',
                'icon' => 'bx-bike',
                'active' => in_array($this->status, ['on_the_way', 'completed']),
                'completed' => $this->status === 'completed'
            ],
            'completed' => [
                'status' => 'Delivered',
                'description' => 'Your order has been delivered',
                'icon' => 'bx-check-shield',
                'active' => $this->status === 'completed',
                'completed' => $this->status === 'completed'
            ]
        ];

        return $timeline;
    }

    // Check if order can be cancelled
    public function getCanBeCancelledAttribute()
    {
        return in_array($this->status, ['pending', 'confirmed']);
    }

    // Check if order can be reviewed
    public function getCanBeReviewedAttribute()
    {
        return $this->status === 'completed' && !$this->reviewed_at;
    }

    // Method untuk timeline progress
    public function getTimelineStatus()
    {
        $timeline = [
            'pending' => ['active' => true, 'completed' => false],
            'confirmed' => ['active' => true, 'completed' => false],
            'preparing' => ['active' => true, 'completed' => false],
            'ready' => ['active' => true, 'completed' => false],
            'on_the_way' => ['active' => true, 'completed' => false],
            'completed' => ['active' => true, 'completed' => true],
            'cancelled' => ['active' => false, 'completed' => false]
        ];

        return $timeline[$this->status] ?? $timeline['pending'];
    }
}
