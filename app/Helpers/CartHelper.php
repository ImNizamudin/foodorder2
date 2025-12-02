<?php

namespace App\Helpers;

if (!function_exists('getCartCount')) {
    function getCartCount()
    {
        $cart = session()->get('cart', []);
        return array_sum(array_column($cart, 'quantity'));
    }
}
