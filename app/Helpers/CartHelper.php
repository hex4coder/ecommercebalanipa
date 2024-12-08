<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Session;

class CartHelper
{
    public static function add($id, $name, $price, $quantity = 1)
    {
        $cart = Session::get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += $quantity;
        } else {
            $cart[$id] = [
                'id' => $id,
                'name' => $name,
                'price' => $price,
                'quantity' => $quantity,
            ];
        }

        Session::put('cart', $cart);
    }

    public static function remove($id)
    {
        $cart = Session::get('cart', []);
        unset($cart[$id]);
        Session::put('cart', $cart);
    }

    public static function update($id, $quantity)
    {
        $cart = Session::get('cart', []);
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $quantity;
        }
        Session::put('cart', $cart);
    }

    public static function getTotal()
    {
        $cart = Session::get('cart', []);
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }

    public static function getTotalItem() {
        return count(Session::get('cart', [])) ?? 0;
    }

    public static function getCart()
    {
        return Session::get('cart', []);
    }

    public static function clearCart()
    {
        Session::forget('cart');
    }
}
