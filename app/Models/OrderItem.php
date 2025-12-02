<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'menu_item_id',
        'quantity',
        'unit_price',
        'total_price',
        'customizations'
    ];

    protected $casts = [
        'customizations' => 'array',
        'unit_price' => 'decimal:2',
        'total_price' => 'decimal:2',
    ];

     public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function menuItem()
    {
        return $this->belongsTo(MenuItem::class, 'menu_item_id');
    }

    public function getFormattedUnitPriceAttribute()
    {
        return 'Rp ' . number_format($this->unit_price, 0, ',', '.');
    }

    public function getFormattedTotalPriceAttribute()
    {
        return 'Rp ' . number_format($this->total_price, 0, ',', '.');
    }

    public function getCustomizationsTextAttribute()
    {
        if (empty($this->customizations)) {
            return '';
        }

        return collect($this->customizations)
            ->map(function ($value, $key) {
                return ucfirst($key) . ': ' . $value;
            })
            ->implode(', ');
    }
}
