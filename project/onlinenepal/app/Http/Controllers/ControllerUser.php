<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Address;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
        $order->status = (string) $order_status;
        $order->save();
        return back()->with('status', 'Order with order id ' . $request->order_id . " has been canceled successfully!");
    }

    /**
     * Show the dashboard with user details.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function dashboard()
    {
        // Retrieve the authenticated user
        $user = Auth::user();

        // Pass the user data to the dashboard view
        return view('user.dashboard', compact('user'));
    }

    /**
     * Update user details like name, mobile, and email.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateDetails(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'required|string|max:15',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
        ]);

        $user = User::find($request->id);

        try {
            $user->name = $request->name;
            $user->mobile = $request->mobile;
            $user->email = $request->email;
            $user->save();

            return back()->with('success', 'Details updated successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update details. Please try again.');
        }
    }

    /**
     * Update user password after checking the old password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::find($request->id);

        if (!Hash::check($request->old_password, $user->password)) {
            return back()->with('error', 'Old password is incorrect.');
        }

        try {
            $user->update([
                'password' => Hash::make($request->new_password),
            ]);

            return back()->with('success', 'Password updated successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update password. Please try again.');
        }
    }

    /**
     * Show the dashboard with user Adress details.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function user_address()
    {
        // Retrieve the authenticated user
        $user = Auth::user();
        // Query the address using the user_id column
        $address = Address::where('user_id', $user->id)->first();
        // Pass the user data to the dashboard view
        return view('user.address', compact('address'));
    }

    public function create_address()
    {
        return view('user.create-address');
    }

    public function storeAddress(Request $request)
    {
        // Validate the input
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'zip' => 'required|string|max:10',
            'province' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'locality' => 'required|string|max:255',
            'landmark' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'isdefault' => 'nullable|boolean',
        ]);

        try {
            // Save the address
            $address = new Address();
            $address->user_id = $request->id;
            $address->name = $request->name;
            $address->phone = $request->phone;
            $address->zip = $request->zip;
            $address->province = $request->province;
            $address->city = $request->city;
            $address->address = $request->address;
            $address->locality = $request->locality;
            $address->landmark = $request->landmark;
            $address->district = $request->district;
            $address->is_default = $request->isdefault ? 1 : 0;
            $address->country = "Nepal";
            $address->save();

            // If "is_default" is checked, reset other addresses' defaults
            if ($address->is_default) {
                Address::where('user_id', $request->id)
                    ->where('id', '!=', $address->id)
                    ->update(['is_default' => 0]);
            }

            return redirect()->route('user.address-details')->with('success', 'Address added successfully!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to add address. Please try again.');
        }
    }

    public function modify_address()
    {
        $user = Auth::user();
        // Query the address using the user_id column
        $address = Address::where('user_id', $user->id)->first();
        return view('user.modify-address',compact('address'));
    }

    public function update_address(Request $request, $id)
{
    // Validate the input
    $request->validate([
        'name' => 'required|string|max:255',
        'phone' => 'required|string|max:15',
        'zip' => 'required|string|max:10',
        'province' => 'required|string|max:255',
        'city' => 'required|string|max:255',
        'address' => 'required|string|max:255',
        'locality' => 'required|string|max:255',
        'landmark' => 'required|string|max:255',
        'district' => 'required|string|max:255',
        'isdefault' => 'nullable|boolean',
    ]);

    try {
        // Find the address by ID
        $address = Address::findOrFail($id);

        // Update address fields
        $address->name = $request->name;
        $address->phone = $request->phone;
        $address->zip = $request->zip;
        $address->province = $request->province;
        $address->city = $request->city;
        $address->address = $request->address;
        $address->locality = $request->locality;
        $address->landmark = $request->landmark;
        $address->district = $request->district;
        $address->is_default = $request->isdefault ? 1 : 0;

        $address->save();

        // If "is_default" is checked, reset other addresses' defaults
        if ($address->is_default) {
            Address::where('user_id', $address->user_id)
                ->where('id', '!=', $address->id)
                ->update(['is_default' => 0]);
        }

        return redirect()->route('user.address-details')->with('success', 'Address updated successfully!');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Failed to add address. Please try again.');
    }
}

}
