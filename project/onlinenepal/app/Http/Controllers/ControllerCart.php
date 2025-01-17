<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;
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

    public function coupons_apply_to_cart(Request $request)
    {
        $coupon_code = $request->coupon_code;
        if(isset($coupon_code))
        {
            // Get the subtotal as a string
            $raw_subtotal = Cart::instance('cart')->subtotal(); // e.g., "100,000.00"

            // Remove commas
            $clean_subtotal = str_replace(',', '', $raw_subtotal); // Result: "100000.00"

            // Convert to a float
            $subtotal = (float) $clean_subtotal;
            $coupon = Coupon::where('code',$coupon_code)->where('expiry_date','>=',Carbon::now())->where('cart_value','<=',$subtotal)->first();
            if(!$coupon)
            {
                return redirect()->back()->with('error','Coupon Code is not valid for website!');
            }
            else
            {
                Session::put('coupon',[
                    'code' => $coupon->code ,
                    'type' => $coupon->type ,
                    'value' => $coupon->value ,
                    'cart_value' => $coupon->cart_value ,
                ]);
                $this->discount_calculator();
                return redirect()->back()->with('success','Coupon code have been applied!');
            }
        }
        else
        {
            return redirect()->back()->with('error','Coupon code is not valid!');
        }
    }

    public function discount_calculator()
    {
        $discount_value = 0;
        if(Session::has('coupon'))
        {
            if(Session::get('coupon')['type']=='fixed')
            {
                $discount = Session::get('coupon')['value'];
            }
            else
            {
                $discount = (Session::get('coupon')['value'] * Cart::instance('cart')->subtotal()) / 100;
            }
            // Get the subtotal as a string
            $raw_subtotal = Cart::instance('cart')->subtotal(); // e.g., "100,000.00"

            // Remove commas
            $clean_subtotal = str_replace(',', '', $raw_subtotal); // Result: "100000.00"

            // Convert to a float
            $subtotal = (float) $clean_subtotal;
            $sub_total_after_discount = $subtotal - $discount;
            $tax_after_discount = ($sub_total_after_discount * config('cart.tax')) / 100;
            $total_after_discount = $sub_total_after_discount + $tax_after_discount;

            Session::put('discounts',[
                'discount' => number_format(floatval($discount),2,'.',''),
                'subtotal' => number_format(floatval($sub_total_after_discount),2,'.',''),
                'tax' => number_format(floatval($tax_after_discount),2,'.',''),
                'total' => number_format(floatval($total_after_discount),2,'.','')

            ]);
        }
    }

    public function delete_coupon_code()
    {
        Session::forget('discounts');
        Session::forget('coupon');
        return redirect()->back()->with('success','Coupon code have been removed!');
    }
}
