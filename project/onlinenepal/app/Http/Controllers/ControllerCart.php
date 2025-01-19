<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Surfsidemedia\Shoppingcart\Facades\Cart;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment; // Switch to LiveEnvironment for production
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;
use App\Mail\OrderConfirmationMail;
use Illuminate\Support\Facades\Mail;


class ControllerCart extends Controller
{

    public function index()
    {
        $items = Cart::instance('cart')->content();
        return view('cart', compact('items'));

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
        $cart_item = Cart::instance('cart')->get($rowid);
        $product_qty = $cart_item->qty + 1;
        Cart::instance('cart')->update($rowid, $product_qty);
        return redirect()->back();
    }

    public function cart_quantity_decrease($rowid)
    {
        $cart_item = Cart::instance('cart')->get($rowid);
        $product_qty = $cart_item->qty - 1;
        Cart::instance('cart')->update($rowid, $product_qty);
        return redirect()->back();
    }

    public function cart_item_remove($rowid)
    {
        $cart_item = Cart::instance('cart')->remove($rowid);
        return redirect()->back();
    }

    public function cart_empty()
    {
        $cart_item = Cart::instance('cart')->destroy();
        return redirect()->back();
    }

    public function coupons_apply_to_cart(Request $request)
    {
        $coupon_code = $request->coupon_code;
        if (isset($coupon_code)) {
            // Get the subtotal as a string
            $raw_subtotal = Cart::instance('cart')->subtotal(); // e.g., "100,000.00"

            // Remove commas
            $clean_subtotal = str_replace(',', '', $raw_subtotal); // Result: "100000.00"

            // Convert to a float
            $subtotal = (float) $clean_subtotal;
            $coupon = Coupon::where('code', $coupon_code)->where('expiry_date', '>=', Carbon::now())->where('cart_value', '<=', $subtotal)->first();
            if (!$coupon) {
                return redirect()->back()->with('error', 'Coupon Code is not valid for website!');
            } else {
                Session::put('coupon', [
                    'code' => $coupon->code,
                    'type' => $coupon->type,
                    'value' => $coupon->value,
                    'cart_value' => $coupon->cart_value,
                ]);
                $this->discount_calculator();
                return redirect()->back()->with('success', 'Coupon code have been applied!');
            }
        } else {
            return redirect()->back()->with('error', 'Coupon code is not valid!');
        }
    }

    public function discount_calculator()
    {
        $discount_value = 0;
        if (Session::has('coupon')) {
            if (Session::get('coupon')['type'] == 'fixed') {
                $discount = Session::get('coupon')['value'];
            } else {
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

            Session::put('discounts', [
                'discount' => number_format(floatval($discount), 2, '.', ''),
                'subtotal' => number_format(floatval($sub_total_after_discount), 2, '.', ''),
                'tax' => number_format(floatval($tax_after_discount), 2, '.', ''),
                'total' => number_format(floatval($total_after_discount), 2, '.', '')

            ]);
        }
    }

    public function delete_coupon_code()
    {
        Session::forget('discounts');
        Session::forget('coupon');
        return redirect()->back()->with('success', 'Coupon code have been removed!');
    }

    public function checkout()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $address = Address::where('user_id', Auth::user()->id)->where('isdefault', 1)->first();
        return view('checkout', compact('address'));
    }

    public function order_place(Request $request)
    {
        $user_id = Auth::user()->id;
        $address = Address::where('user_id', $user_id)->where('isdefault', 1)->first();

        if (!$address) {
            $request->validate([
                'name' => 'required|max:100',
                'address' => 'required',
                'landmark' => 'required',
                'phone' => 'required|numeric|digits:10',
                'zip' => 'required|numeric|digits:5',
                'province' => 'required',
                'city' => 'required',
                'locality' => 'required',
                'district' => 'required',
            ]);

            $address = new Address();
            $address->fill($request->only(['name', 'address', 'landmark', 'phone', 'zip', 'province', 'city', 'locality', 'district']));
            $address->country = 'Nepal';
            $address->isdefault = true;
            $address->user_id = $user_id;
            $address->save();
        }

        $this->amounts_at_checkout();
        $order = new Order();
        $order->fill([
            'user_id' => $user_id,
            'subtotal' => (float) str_replace(',', '', Session::get('checkout')['subtotal']),
            'discount' => (float) str_replace(',', '', Session::get('checkout')['discount']),
            'tax' => (float) str_replace(',', '', Session::get('checkout')['tax']),
            'total' => (float) str_replace(',', '', Session::get('checkout')['total']),
            'locality' => $address->locality,
            'name' => $address->name,
            'phone' => $address->phone,
            'address' => $address->address,
            'city' => $address->city,
            'province' => $address->province,
            'district' => $address->district,
            'country' => 'Nepal',
            'landmark' => $address->landmark,
            'zip' => $address->zip,
        ]);
        $order->save();

        foreach (Cart::instance('cart')->content() as $item) {
            OrderItem::create([
                'product_id' => $item->id,
                'order_id' => $order->id,
                'price' => (float) str_replace(',', '', $item->price),
                'quantity' => $item->qty,
            ]);
        }

        $transaction = new Transaction();
        $transaction->user_id = $user_id;
        $transaction->order_id = $order->id;
        $transaction->mode = $request->mode;
        $transaction->status = $request->has('payment_id') ? 'approved' : 'pending';
        $transaction->save();
        Cart::instance('cart')->destroy();
        Session::forget('checkout');
        Session::forget('coupon');
        Session::forget('discounts');
        Session::put('order_id', $order->id);
        $order_id = Session::get('order_id');
        $order = Order::find($order_id);
        // Send the order confirmation email
        Mail::to($order->user->email)->send(new OrderConfirmationMail($order_id));


        return redirect()->route('cart.confirmation.of.order');
    }


    public function amounts_at_checkout()
    {
        if (!Cart::instance('cart')->content()->count() > 0) {
            Session::forget('checkout');
            return;
        }

        if (Session::has('coupon')) {
            Session::put('checkout', [
                'discount' => Session::get('discounts')['discount'],
                'tax' => Session::get('discounts')['tax'],
                'total' => Session::get('discounts')['total'],
                'subtotal' => Session::get('discounts')['subtotal']
            ]);
        } else {
            Session::put('checkout', [
                'discount' => 0,
                'tax' => Cart::instance('cart')->tax(),
                'total' => Cart::instance('cart')->total(),
                'subtotal' => Cart::instance('cart')->subtotal()
            ]);
        }
    }

    public function confirmation_of_order()
    {
        if (Session::has('order_id')) {
            $order = Order::find(Session::get('order_id'));
            return view('confirmation_of_order', compact('order'));
        }
        return redirect()->route('cart.index');
    }

    public function handlePayPal(Request $request)
    {
        // Save checkout data in the session
        Session::put('checkout_data', $request->all());

        // Example conversion logic
        $this->amounts_at_checkout();
        $nprAmount = Session::get('checkout')['total']; // Replace with your calculation
        $nprAmount = floatval(str_replace(',', '', $nprAmount)); // Clean and convert to float
        $conversionRate = 120; // 1 USD = 120 NPR
        $usdAmount = round($nprAmount / $conversionRate, 2);

        // PayPal client setup
        $clientId = config('services.paypal.client_id');
        $clientSecret = config('services.paypal.secret');
        $environment = new SandboxEnvironment($clientId, $clientSecret);
        $client = new PayPalHttpClient($environment);

        // Create the order request
        $orderRequest = new OrdersCreateRequest();
        $orderRequest->prefer('return=representation');
        $orderRequest->body = [
            'intent' => 'CAPTURE',
            'purchase_units' => [
                [
                    'amount' => [
                        'currency_code' => 'USD',
                        'value' => $usdAmount,
                    ],
                ]
            ],
            'application_context' => [
                'return_url' => route('paypal.success'),
                'cancel_url' => route('paypal.cancel'),
            ],
        ];

        try {
            // Create the PayPal order
            $response = $client->execute($orderRequest);

            // Get the approval URL
            foreach ($response->result->links as $link) {
                if ($link->rel === 'approve') {
                    return redirect()->away($link->href);
                }
            }

            return redirect()->back()->with('error', 'Unable to process payment. Please try again.');
        } catch (\Exception $ex) {
            logger()->error('PayPal Error', ['message' => $ex->getMessage()]);
            return redirect()->back()->with('error', 'Unable to process payment. Please try again.');
        }
    }



    public function paypalSuccess(Request $request)
    {
        $orderId = $request->get('token'); // PayPal uses `token` for the order ID

        if (!$orderId) {
            return redirect()->route('cart.index')->with('error', 'Payment failed or canceled.');
        }

        // PayPal client setup
        $clientId = config('services.paypal.client_id');
        $clientSecret = config('services.paypal.secret');
        $environment = new SandboxEnvironment($clientId, $clientSecret);
        $client = new PayPalHttpClient($environment);

        // Capture the payment
        $captureRequest = new OrdersCaptureRequest($orderId);
        $captureRequest->prefer('return=representation');

        try {
            $response = $client->execute($captureRequest);

            if ($response->result->status === 'COMPLETED') {
                // Pass data to the view
                return view('paypal-success', [
                    'paymentId' => $orderId, // Use $orderId as the equivalent of $paymentId
                    'payerId' => $response->result->payer->payer_id, // Extract the payer_id
                    'checkoutData' => Session::get('checkout_data'), // Retrieve saved checkout data
                ]);
            }
        } catch (\Exception $ex) {
            logger()->error('PayPal Error', ['message' => $ex->getMessage()]);
            return redirect()->route('cart.index')->with('error', 'Payment verification failed.');
        }

        return redirect()->route('cart.index')->with('error', 'Payment verification failed.');
    }



    public function paypalCancel()
    {
        return redirect()->route('cart.index')->with('error', 'Payment canceled.');
    }

}