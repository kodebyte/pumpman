<?php
namespace App\Helpers;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartHelper {
    public static function count() {
        $cart = null;
        if (Auth::check()) {
            $cart = Cart::where('user_id', Auth::id())->first();
        } else {
            $cart = Cart::where('session_id', Session::getId())->first();
        }
        return $cart ? $cart->items()->count() : 0;
    }
}