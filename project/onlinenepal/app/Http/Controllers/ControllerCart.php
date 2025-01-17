<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Surfsidemedia\Shoppingcart\Facades\Cart;

class ControllerCart extends Controller
{
    public function index()
    {
        $items = Cart::instance('cart')->content();
        return view('cart',compact('items'));

    }

    public function add_to_cart(Request $request)
    {
        Cart::instance('cart')->add($request->id, $request->name, $request->quantity, $request->price, [
            'image' => $request->image // Store image in the options array
        ])->associate('App\Models\Product');
        return redirect()->back();
    }
}
