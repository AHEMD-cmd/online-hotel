<?php


namespace App\Services;

use App\Models\Cart;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cookie;

class CartService
{
    public function getCartId()
    {
        $id = request()->cookie('cart_id');
        if (!$id) {
            $id = Str::uuid();
            Cookie::queue('cart_id', $id, 60 * 24 * 30);
        }

        return $id;
    }

    public function deleteCart()
    {
        Cart::where('user_id', auth()->id())->delete();
    }
}