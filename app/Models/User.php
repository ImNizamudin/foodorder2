<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */

    const ROLE_ADMIN = 'admin';
    const ROLE_OWNER = 'owner';
    const ROLE_CUSTOMER = 'customer';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isAdmin()
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isOwner()
    {
        return $this->role === self::ROLE_OWNER;
    }

    public function isCustomer()
    {
        return $this->role === self::ROLE_CUSTOMER;
    }

    // ✅ TAMBAHKAN RELATIONSHIP KE RESTAURANT
    public function restaurants()
    {
        return $this->hasOne(Restaurant::class);
    }

    public function hasRestaurant()
    {
        return $this->restaurants()->exists();
    }

    public function getRestaurantAttribute()
    {
        return $this->restaurants()->first();
    }

    // public function getRedirectRoute()
    // {
    //     return match($this->role) {
    //         'admin' => '/admin/dashboard',
    //         'owner' => '/owner/dashboard',
    //         'customer' => '/',
    //         default => '/'
    //     };
    // }
}
