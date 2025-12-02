<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Restaurant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'address',
        'phone',
        'email',
        'logo',
        'cover_image',
        'status',
        'user_id',
        'delivery_time',
        'delivery_fee',
        'min_order',
        'rating',
        'total_ratings'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function menuItems()
    {
        return $this->hasMany(MenuItem::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function getStatusBadgeAttribute()
    {
        return $this->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800';
    }

    public function getFormattedDeliveryFeeAttribute()
    {
        return 'Rp ' . number_format($this->delivery_fee, 0, ',', '.');
    }

    public function getFormattedMinOrderAttribute()
    {
        return 'Rp ' . number_format($this->min_order, 0, ',', '.');
    }

    // Accessor yang lebih dinamis berdasarkan data aktual
    public function getMinOrderAttribute($value)
    {
        return $value ?? 25000; // Use actual value if exists, otherwise default
    }

    public function getRatingAttribute($value)
    {
        // Jika ada rating di database, gunakan itu
        if ($value !== null) {
            return $value;
        }

        // Default rating berdasarkan jumlah menu items (simulasi popularity)
        $menuItemsCount = $this->menuItems()->where('is_available', true)->count();
        if ($menuItemsCount > 10) return 4.8;
        if ($menuItemsCount > 5) return 4.5;
        if ($menuItemsCount > 2) return 4.2;
        return 4.0;
    }

    public function getDeliveryTimeAttribute($value)
    {
        // Jika ada delivery_time di database, gunakan itu
        if ($value !== null) {
            return $value;
        }

        // Default delivery time berdasarkan rating (simulasi)
        $rating = $this->getRatingAttribute($this->attributes['rating'] ?? null);
        if ($rating > 4.5) return '20-30';
        if ($rating > 4.0) return '25-35';
        return '30-45';
    }

    public function getDeliveryFeeAttribute($value)
    {
        return $value ?? 5000; // Use actual value if exists, otherwise default
    }

    // Helper untuk price range simulation
    public function getPriceRangeAttribute()
    {
        $avgPrice = $this->menuItems()->where('is_available', true)->avg('price');

        if (!$avgPrice) return 2; // Default medium price

        if ($avgPrice < 25000) return 1; // $
        if ($avgPrice < 50000) return 2; // $$
        if ($avgPrice < 75000) return 3; // $$$
        return 4; // $$$$
    }

    public function getCoverImageUrlAttribute()
    {
        if ($this->cover_image && file_exists(public_path('storage/' . $this->cover_image))) {
            return asset('storage/' . $this->cover_image);
        }

        if ($this->logo && file_exists(public_path('storage/' . $this->logo))) {
            return asset('storage/' . $this->logo);
        }

        // Fallback ke random food image berdasarkan ID restaurant
        $foodImages = [
            'burger' => 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?auto=format&fit=crop&w=600&h=400&q=80',
            'pizza' => 'https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?auto=format&fit=crop&w=600&h=400&q=80',
            'sushi' => 'https://images.unsplash.com/photo-1579584425555-c3ce17fd4351?auto=format&fit=crop&w=600&h=400&q=80',
            'noodles' => 'https://images.unsplash.com/photo-1557872943-16a5ac26437e?auto=format&fit=crop&w=600&h=400&q=80',
            'curry' => 'https://images.unsplash.com/photo-1585937421612-70ca003675ed?auto=format&fit=crop&w=600&h=400&q=80',
            'tacos' => 'https://images.unsplash.com/photo-1565299585323-38d6b0865b47?auto=format&fit=crop&w=600&h=400&q=80',
            'salad' => 'https://images.unsplash.com/photo-1540420773420-3366772f4999?auto=format&fit=crop&w=600&h=400&q=80',
            'dessert' => 'https://images.unsplash.com/photo-1563729784474-d77dbb933a9e?auto=format&fit=crop&w=600&h=400&q=80',
            'coffee' => 'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?auto=format&fit=crop&w=600&h=400&q=80',
            'breakfast' => 'https://images.unsplash.com/photo-1484723091739-30a097e8f929?auto=format&fit=crop&w=600&h=400&q=80',
        ];

        // Pilih image berdasarkan hash restaurant ID untuk konsistensi
        $hash = crc32($this->id);
        $imageKeys = array_keys($foodImages);
        $selectedKey = $imageKeys[$hash % count($imageKeys)];

        return $foodImages[$selectedKey];
    }

    // Accessor untuk logo URL
    public function getLogoUrlAttribute()
    {
        if ($this->logo && file_exists(public_path('storage/' . $this->logo))) {
            return asset('storage/' . $this->logo);
        }

        return null;
    }

    // Helper untuk mendapatkan cuisine types
    public function getCuisineTypesAttribute()
    {
        return $this->menuItems
            ->load('category')
            ->pluck('category.name')
            ->filter()
            ->unique()
            ->values()
            ->toArray();
    }

    // Helper untuk mendapatkan price range symbol
    public function getPriceRangeSymbolAttribute()
    {
        $priceRange = $this->price_range ?? 2;
        $symbols = [
            1 => '💰',
            2 => '💰💰',
            3 => '💰💰💰',
            4 => '💰💰💰💰'
        ];

        return $symbols[$priceRange] ?? '💰💰';
    }

    // Helper untuk mendapatkan order count (simulated)
    public function getOrderCountAttribute()
    {
        $menuItemsCount = $this->menuItems()->where('is_available', true)->count();
        $baseOrders = $menuItemsCount * 15; // Simulasi

        // Tambahkan randomness berdasarkan rating
        $ratingBonus = ($this->rating - 4.0) * 50;

        return max(50, $baseOrders + $ratingBonus);
    }
}
