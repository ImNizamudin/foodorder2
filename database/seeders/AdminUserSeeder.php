<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin FoodOrder',
            'email' => 'admin@foodorder.com',
            'password' => Hash::make('password'),
            'role' => User::ROLE_ADMIN,
            'phone' => '+6281122334455'
        ]);

        $owners = [
            [
                'name' => 'Budi Santoso',
                'email' => 'budi@warungenak.com',
                'password' => Hash::make('password'),
                'role' => User::ROLE_OWNER,
                'phone' => '+6281234567890'
            ],
            [
                'name' => 'Sari Wijaya',
                'email' => 'sari@sushimaster.com',
                'password' => Hash::make('password'),
                'role' => User::ROLE_OWNER,
                'phone' => '+6281234567891'
            ],
            [
                'name' => 'Andi Pratama',
                'email' => 'andi@burgerkingdom.com',
                'password' => Hash::make('password'),
                'role' => User::ROLE_OWNER,
                'phone' => '+6281234567892'
            ],
            [
                'name' => 'Lisa Handayani',
                'email' => 'lisa@noodlehouse.com',
                'password' => Hash::make('password'),
                'role' => User::ROLE_OWNER,
                'phone' => '+6281234567893'
            ]
        ];

        foreach ($owners as $owner) {
            User::create($owner);
        }

        $customers = [
            [
                'name' => 'Customer Demo',
                'email' => 'customer@foodorder.com',
                'password' => Hash::make('password'),
                'role' => User::ROLE_CUSTOMER,
                'phone' => '+6281234567899'
            ],
            [
                'name' => 'Rina Melati',
                'email' => 'rina@example.com',
                'password' => Hash::make('password'),
                'role' => User::ROLE_CUSTOMER,
                'phone' => '+6281234567800'
            ],
            [
                'name' => 'David Lee',
                'email' => 'david@example.com',
                'password' => Hash::make('password'),
                'role' => User::ROLE_CUSTOMER,
                'phone' => '+6281234567801'
            ]
        ];

        foreach ($customers as $customer) {
            User::create($customer);
        }
    }
}
