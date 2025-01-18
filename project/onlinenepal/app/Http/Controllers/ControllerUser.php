<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ControllerUser extends Controller
{
    public function index()
    {
        return view('user.index');
    }

    public function orders()
    {
        $orders = Order::where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->paginate(12);
        return view('user.orders', compact('orders'));
    }

    public function details_about_orders($order_id)
    {
        $order = Order::where('user_id', Auth::user()->id)->where('id', $order_id)->first();
        $orderItems = OrderItem::where('order_id', $order_id)->orderBy('id', 'DESC')->paginate(12);
        $transaction = Transaction::where('order_id', $order_id)->first();
        return view('user.details_about_order', compact('order', 'orderItems', 'transaction'));
    }

    public function order_status_update(Request $request)
    {
        $order = Order::find($request->order_id);
        $order_status = $request->order_status;
        if (!in_array($order_status, ['ordered', 'delivered', 'canceled'])) {
            return back()->withErrors(['error' => 'Invalid status value.']);
        }
        $order->canceled_date = Carbon::now();
        $order->status = (string)$order_status;
        $order->save();
        return back()->with('status', 'Order with order id ' . $request->order_id . " has been canceled successfully!");
    }
}
