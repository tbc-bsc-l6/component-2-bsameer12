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

    public function cart_quantity_increase($rowid)
    {
        $cart_item = Cart:: instance('cart')->get($rowid);
        $product_qty = $cart_item->qty + 1 ;
        Cart::instance('cart')->update($rowid,$product_qty );
        return redirect()->back();
    }

    public function cart_quantity_decrease($rowid)
    {
        $cart_item = Cart:: instance('cart')->get($rowid);
        $product_qty = $cart_item->qty - 1 ;
        Cart::instance('cart')->update($rowid,$product_qty );
        return redirect()->back();
    }

    public function cart_item_remove($rowid)
    {
        $cart_item = Cart:: instance('cart')->remove($rowid);
        return redirect()->back();
    }

    public function cart_empty()
    {
        $cart_item = Cart:: instance('cart')->destroy();
        return redirect()->back();
    }
}
