<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\User;
use App\Models\Slide;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\str;
use Illuminate\Support\Facades\File;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ControllerAdmin extends Controller
{
    public function index()
    {
        $orders = Order::orderBy('created_at','DESC')->get()->take(10);
        $data_for_dashboard = DB::select("Select sum(total) As Total_Sales_Amount,
                                            sum(discount) As Total_Discount_Amount,
                                            sum(if(status='ordered',total,0)) As Total_Ordered_Amount,
                                            sum(if(status='delivered',total,0)) As Total_delivered_Amount,
                                            sum(if(status='canceled',total,0)) As Total_Canceled_Amount,
                                            Count(*) As total,
                                            sum(if(status='ordered',1,0)) As Total_Ordered,
                                            sum(if(status='delivered',1,0)) As Total_delivered,
                                            sum(if(status='canceled',1,0)) As Total_Canceled
                                            From Orders
                                            ");
        $total_brand = Brand::count();
        $total_categories = Category::count();
        $total_products = Product::count();
        $total_coupons = Coupon::count();
        $total_quantity_sold = DB::table('order_items')->sum('quantity');
        // Get the product with the minimum regular_price
        $min_price_product = Product::orderBy('regular_price', 'ASC')->first();
        $min_price_product_name = $min_price_product ? $min_price_product->name : 'No products available';

        // Get the product with the maximum regular_price
        $max_price_product = Product::orderBy('regular_price', 'DESC')->first();
        $max_price_product_name = $max_price_product ? $max_price_product->name : 'No products available';
        return view('admin.index',compact('orders','data_for_dashboard','total_brand','total_categories','total_products','min_price_product_name','max_price_product_name','total_coupons','total_quantity_sold'));
    }

    public function brands()
    {
        $brands = Brand::orderBy('id', 'DESC')->paginate(10);
        return view('admin.brands', compact('brands'));
    }

    public function add_brand()
    {
        return view('admin.brand-add');
    }

    public function save_brand(Request $request)
    {
        $request->validate(
            [
                'name' => 'required',
                'slug' => 'required|unique:brands,slug',
                'image' => 'mimes:png,jpg|max:2048'
            ]
        );

        $brand = new Brand();
        $brand->name = $request->name;
        $brand->slug = str::slug($request->name);
        $image = $request->file('image');
        $file_extension = $request->file('image')->extension();
        $file_name = Carbon::now()->timestamp . '.' . $file_extension;
        $this->SaveBrandImage($image, $file_name);
        $brand->image = $file_name;
        $brand->save();
        return redirect()->route('admin.brands')->with('status', 'Brand ' . $request->name . " has been added successfully!");



    }

    public function SaveBrandImage($image, $filename)
    {
        $destination_path = public_path("uploads/brands");
        $img = Image::read($image->path());
        $img->cover(124, 124, 'top');
        $img->resize(124, 124, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destination_path . '/' . $filename);
    }

    public function modify_brand($id)
    {
        $brand = Brand::find($id);
        return view('admin.brand-modify', compact('brand'));
    }

    public function brand_update(Request $request)
    {
        $request->validate(
            [
                'name' => 'required',
                'slug' => 'required|unique:brands,slug,' . $request->id,
                'image' => 'mimes:png,jpg|max:2048'
            ]
        );

        $brand = Brand::find($request->id);
        $brand->name = $request->name;
        $brand->slug = str::slug($request->name);
        if ($request->hasFile('image')) {
            if (File::exists(public_path('uploads/brands') . '/' . $brand->image)) {
                File::delete(public_path('uploads/brands') . '/' . $brand->image);
            }
            $image = $request->file('image');
            $file_extension = $request->file('image')->extension();
            $file_name = Carbon::now()->timestamp . '.' . $file_extension;
            $this->SaveBrandImage($image, $file_name);
            $brand->image = $file_name;
        }
        $brand->save();
        return redirect()->route('admin.brands')->with('status', 'Brand ' . $request->name . " has been updated successfully!");
    }

    public function remove_brand($id)
    {
        $brand = Brand::find($id);
        if (File::exists(public_path('uploads/brands') . '/' . $brand->image)) {
            File::delete(public_path('uploads/brands') . '/' . $brand->image);
        }
        $brand_name = $brand->name;
        $brand->delete();
        return redirect()->route('admin.brands')->with('status', 'Brand ' . $brand_name . " has been deleted successfully!");
        ;
    }

    public function category()
    {
        $category = Category::orderBy('id', 'DESC')->paginate(10);
        return view('admin.category', compact('category'));
    }

    public function create_category()
    {
        return view('admin.category-create');
    }

    public function save_category(Request $request)
    {
        $request->validate(
            [
                'name' => 'required',
                'slug' => 'required|unique:categories,slug',
                'image' => 'mimes:png,jpg|max:2048'
            ]
        );

        $cat = new Category();
        $cat->name = $request->name;
        $cat->slug = str::slug($request->name);
        $image = $request->file('image');
        $file_extension = $request->file('image')->extension();
        $file_name = Carbon::now()->timestamp . '.' . $file_extension;
        $this->SaveCategoryImage($image, $file_name);
        $cat->image = $file_name;
        $cat->save();
        return redirect()->route('admin.category')->with('status', 'Category ' . $request->name . " has been added successfully!");



    }

    public function SaveCategoryImage($image, $filename)
    {
        $destination_path = public_path("uploads/category_images");
        $img = Image::read($image->path());
        $img->cover(124, 124, 'top');
        $img->resize(124, 124, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destination_path . '/' . $filename);
    }


    public function modify_category($id)
    {
        $cat = Category::find($id);
        return view('admin.category_modify', compact('cat'));
    }

    public function category_update(Request $request)
    {
        $request->validate(
            [
                'name' => 'required',
                'slug' => 'required|unique:categories,slug,' . $request->id,
                'image' => 'mimes:png,jpg|max:2048'
            ]
        );

        $cat = Category::find($request->id);
        $cat->name = $request->name;
        $cat->slug = str::slug($request->name);
        if ($request->hasFile('image')) {
            if (File::exists(public_path('uploads/category_images') . '/' . $cat->image)) {
                File::delete(public_path('uploads/category_images') . '/' . $cat->image);
            }
            $image = $request->file('image');
            $file_extension = $request->file('image')->extension();
            $file_name = Carbon::now()->timestamp . '.' . $file_extension;
            $this->SaveBrandImage($image, $file_name);
            $cat->image = $file_name;
        }
        $cat->save();
        return redirect()->route('admin.category')->with('status', 'Category ' . $request->name . " has been updated successfully!");
    }

    public function remove_category($id)
    {
        $cat = Category::find($id);
        if (File::exists(public_path('uploads/category_images') . '/' . $cat->image)) {
            File::delete(public_path('uploads/category_images') . '/' . $cat->image);
        }
        $cat_name = $cat->name;
        $cat->delete();
        return redirect()->route('admin.category')->with('status', 'Category ' . $cat_name . " has been deleted successfully!");
        ;
    }

    public function products()
    {
        $products = Product::orderby('created_at', 'DESC')->paginate(10);
        return view('admin.products', compact('products'));
    }

    public function create_products()
    {
        $categories = Category::select('id', 'name')->orderBy('name')->get();
        $brands = Brand::select('id', 'name')->orderBy('name')->get();
        return redirect()->route('admin.product.create', compact('categories', 'brands'));

    }


    public function save_products(Request $request)
    {
        $request->validate(
            [
                'name' => 'required',
                'slug' => 'required|unique:products,slug',
                'short_description' => 'required',
                'description' => 'required',
                'regular_price' => 'required',
                'sale_price' => 'required',
                'SKU' => 'required',
                'stock_status' => 'required',
                'featured' => 'required',
                'quantity' => 'required',
                'category_id' => 'required',
                'brand_id' => 'required',
                'image' => 'required|mimes:png,jpg|max:2048',
                'images.*' => 'nullable|mimes:png,jpg,jpeg|max:2048'

            ]
        );

        $product = new Product();
        $product->name = $request->name;
        $product->slug = str::slug($request->name);
        $product->short_description = $request->short_description;
        $product->description = $request->description;
        $product->regular_price = $request->regular_price;
        $product->sales_price = $request->sale_price;
        $product->SKU = $request->SKU;
        $product->stock_status = $request->stock_status;
        $product->featured = $request->featured;
        $product->quantity = $request->quantity;
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;
        $image = $request->file('image');
        $file_extension = $request->file('image')->extension();
        $file_name = Carbon::now()->timestamp . '.' . $file_extension;
        $this->SaveProductsImage($image, $file_name);
        $product->image = $file_name;
        $gallery_array = array();
        $gallery_images = "";
        $counter = 1;
        if ($request->hasFile('images')) {
            $allowedfileExtension = ['jpg', 'png', 'jpeg'];
            $files = $request->file('images');
            foreach ($files as $file) {
                $file_extension = $file->getClientOriginalExtension();
                $check = in_array($file_extension, $allowedfileExtension);
                if ($check) {
                    $file_name = Carbon::now()->timestamp . '_' . uniqid() . '_' . $counter . '.' . $file_extension;
                    $this->SaveProductsImage($file, $file_name);
                    array_push($gallery_array, $file_name);
                    $counter++;

                }

            }
            $gallery_images = implode(',', $gallery_array);
        }
        $product->images = $gallery_images;
        $product->save();
        return redirect()->route('admin.products')->with('status', 'Product ' . $request->name . " has been added successfully!");



    }

    public function SaveProductsImage($image, $filename)
    {
        $destination_path = public_path("uploads/products");
        $img = Image::read($image->path());
        $img->cover(540, 689, 'top');
        $img->resize(540, 689, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destination_path . '/' . $filename);
    }

    public function modify_products($id)
    {
        $product = Product::find($id);
        $categories = Category::select('id', 'name')->orderBy('name')->get();
        $brands = Brand::select('id', 'name')->orderBy('name')->get();
        return view('admin.products_modify', compact('product', 'categories', 'brands'));
    }

    public function update_product(Request $request)
    {
        $request->validate(
            [
                'id' => 'required|exists:products,id', // Ensure the product ID exists in the database
                'name' => 'required',
                'slug' => 'required|unique:products,slug,' . $request->id, // Ignore the current product's slug
                'short_description' => 'required',
                'description' => 'required',
                'regular_price' => 'required',
                'sale_price' => 'required',
                'SKU' => 'required',
                'stock_status' => 'required',
                'featured' => 'required',
                'quantity' => 'required',
                'category_id' => 'required',
                'brand_id' => 'required',
                'image' => 'nullable|mimes:png,jpg|max:2048',
                'images.*' => 'nullable|mimes:png,jpg,jpeg|max:2048'
            ]
        );

        // Retrieve the product by its ID
        $product = Product::findOrFail($request->id);

        // Update product details
        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
        $product->short_description = $request->short_description;
        $product->description = $request->description;
        $product->regular_price = $request->regular_price;
        $product->sales_price = $request->sale_price;
        $product->SKU = $request->SKU;
        $product->stock_status = $request->stock_status;
        $product->featured = $request->featured;
        $product->quantity = $request->quantity;
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;

        // Handle main image update
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($product->image && file_exists(public_path("uploads/products/" . $product->image))) {
                unlink(public_path("uploads/products/" . $product->image));
            }

            $image = $request->file('image');
            $file_extension = $image->extension();
            $file_name = Carbon::now()->timestamp . '.' . $file_extension;
            $this->SaveProductsImage($image, $file_name);
            $product->image = $file_name;
        }

        // Handle gallery images update
        $gallery_array = $product->images ? explode(',', $product->images) : [];
        if ($request->hasFile('images')) {
            $allowedfileExtension = ['jpg', 'png', 'jpeg'];
            $files = $request->file('images');
            $counter = count($gallery_array) + 1;

            foreach ($files as $file) {
                $file_extension = $file->getClientOriginalExtension();
                $check = in_array($file_extension, $allowedfileExtension);
                if ($check) {
                    $file_name = Carbon::now()->timestamp . '_' . uniqid() . '_' . $counter . '.' . $file_extension;
                    $this->SaveProductsImage($file, $file_name);
                    array_push($gallery_array, $file_name);
                    $counter++;
                }
            }
        }

        $product->images = implode(',', $gallery_array);

        // Save the updated product
        $product->save();

        return redirect()->route('admin.products')->with('status', 'Product ' . $request->name . " has been updated successfully!");
    }

    public function remove_product($id)
    {
        // Find the product by ID
        $product = Product::findOrFail($id);

        // Delete the main image if it exists
        if ($product->image && file_exists(public_path("uploads/products/" . $product->image))) {
            unlink(public_path("uploads/products/" . $product->image));
        }

        // Delete the gallery images if they exist
        if ($product->images) {
            $gallery_images = explode(',', $product->images);
            foreach ($gallery_images as $image) {
                if (file_exists(public_path("uploads/products/" . $image))) {
                    unlink(public_path("uploads/products/" . $image));
                }
            }
        }

        // Delete the product from the database
        $product->delete();

        return redirect()->route('admin.products')->with('status', 'Product has been deleted successfully!');
    }

    public function coupons()
    {
        $coupons = Coupon::orderBy('expiry_date', 'DESC')->paginate(12);
        return view('admin.coupons', compact('coupons'));
    }

    public function coupons_add()
    {
        return view('admin.coupons_create');
    }

    public function save_coupon(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:coupons',
            'type' => 'required',
            'value' => 'required|numeric',
            'cart_value' => 'required|numeric',
            'expiry_date' => 'required|date',
        ]);

        $coupon = new Coupon();
        $coupon->code = $request->code;
        $coupon->type = $request->type;
        $coupon->value = $request->value;
        $coupon->cart_value = $request->cart_value;
        $coupon->expiry_date = $request->expiry_date;
        $coupon->save();
        return redirect()->route('admin.coupons')->with('status', 'Coupon ' . $request->code . " has been added successfully!");
    }

    public function modify_coupon($id)
    {
        $coupon = Coupon::find($id);
        $coupon->expiry_date = \Carbon\Carbon::parse($coupon->expiry_date)->format('Y-m-d');
        return view('admin.coupons_modify', compact('coupon'));
    }

    public function coupon_update(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:coupons,code,' . $request->id,
            'type' => 'required',
            'value' => 'required|numeric',
            'cart_value' => 'required|numeric',
            'expiry_date' => 'required|date',
        ]);

        $coupon = Coupon::find($request->id);
        $coupon->code = $request->code;
        $coupon->type = $request->type;
        $coupon->value = $request->value;
        $coupon->cart_value = $request->cart_value;
        $coupon->expiry_date = $request->expiry_date;
        $coupon->save();
        return redirect()->route('admin.coupons')->with('status', 'Coupon ' . $request->code . " has been updated successfully!");
    }

    public function remove_coupon($id)
    {
        $coupon = Coupon::find($id);
        $coupon_code = $coupon->code;
        $coupon->delete();
        return redirect()->route('admin.coupons')->with('status', 'Coupon ' . $coupon_code . " has been deleted successfully!");
    }

    public function orders()
    {
        $orders = Order::orderBy('created_at', 'DESC')->paginate(12);
        return view('admin.orders', compact('orders'));
    }

    public function details_about_orders($order_id)
    {
        $order = Order::find($order_id);
        $orderItems = OrderItem::where('order_id', $order_id)->orderBy('id', 'DESC')->paginate(12);
        $transaction = Transaction::where('order_id', $order_id)->first();
        return view('admin.details_about_order', compact('order', 'orderItems', 'transaction'));
    }

    public function order_status_update(Request $request)
    {
        $order = Order::find($request->order_id);
        $order_status = $request->order_status;
        if ($order_status == 'delivered') {
            $order->delivered_date = Carbon::now();
        } elseif ($order_status == 'canceled') {
            $order->canceled_date = Carbon::now();
        }
        $order->status = $order_status;
        $order->save();
        if ($order_status == 'delivered') {
            $transaction = Transaction::where('order_id', $request->order_id)->first();
            $transaction->status = 'approved';
            $transaction->save();
        }
        return back()->with('status', 'Order status for order id ' . $request->order_id . " has been updated successfully!");
    }

    public function slide()
    {
        $slides = Slide::orderBy('id', 'Desc')->paginate(12);
        return view('admin.slides', compact('slides'));
    }

    public function slider_create()
    {
        return view('admin.slide_create');
    }

    public function save_slider(Request $request)
    {
        $request->validate([
            'tagline' => 'required',
            'title' => 'required',
            'subtitle' => 'required',
            'image' => 'required|mimes:png,jpeg,jpg|max:2048',
            'link' => 'required',
            'status' => 'required',
        ]);
        $slide = new Slide();
        $slide->title = $request->title;
        $slide->tagline = $request->tagline;
        $slide->subtitle = $request->subtitle;
        $slide->image = $request->image;
        $slide->link = $request->link;
        $slide->status = $request->status;
        $image = $request->file('image');
        $file_extension = $request->file('image')->extension();
        $file_name = Carbon::now()->timestamp . '.' . $file_extension;
        $this->SaveSlideImage($image, $file_name);
        $slide->image = $file_name;
        $slide->save();
        return redirect()->route('admin.slides')->with('status', 'Slide ' . $request->title . " has been added successfully!");
    }


    public function SaveSlideImage($image, $filename)
    {
        $destination_path = public_path("uploads/slides");
        $img = Image::read($image->path());
        $img->cover(400, 690, 'top');
        $img->resize(400, 690, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destination_path . '/' . $filename);
    }

    public function modify_slider($id)
    {

        $slide = Slide::find($id);
        return view('admin.slide_modify', compact('slide'));
    }

    public function update_slider(Request $request)
    {
        $request->validate([
            'tagline' => 'required',
            'title' => 'required',
            'subtitle' => 'required',
            'image' => 'required|mimes:png,jpeg,jpg|max:2048',
            'link' => 'required',
            'status' => 'required',
        ]);
        $slide = Slide::find($request->id);
        $slide->title = $request->title;
        $slide->tagline = $request->tagline;
        $slide->subtitle = $request->subtitle;
        $slide->image = $request->image;
        $slide->link = $request->link;
        $slide->status = $request->status;
        if ($request->hasFile('image')) {
            if (File::exists(public_path('uploads/slides') . '/' . $slide->image)) {
                File::delete(public_path('uploads/slides') . '/' . $slide->image);
            }
            $image = $request->file('image');
            $file_extension = $request->file('image')->extension();
            $file_name = Carbon::now()->timestamp . '.' . $file_extension;
            $this->SaveSlideImage($image, $file_name);
            $slide->image = $file_name;
        }
        $slide->save();
        return redirect()->route('admin.slides')->with('status', 'Slide ' . $request->title . " has been updated successfully!");
    }

    public function remove_slide($id)
    {
        $slide = Slide::find($id);
        if (File::exists(public_path('uploads/slides') . '/' . $slide->image)) {
            File::delete(public_path('uploads/cslides') . '/' . $slide->image);
        }
        $slide_title = $slide->title;
        $slide->delete();
        return redirect()->route('admin.slides')->with('status', 'Slide ' . $slide_title . " has been deleted successfully!");
        ;
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        if (!$query) {
            return response()->json(['error' => 'Query parameter is required'], 400);
        }

        $results = Product::where('name', 'LIKE', "%{$query}%")
            ->select('id', 'name', 'slug', 'image')
            ->take(8)
            ->get();

        if ($results->isEmpty()) {
            return response()->json(['message' => 'No products found'], 404);
        }

        return response()->json($results);
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
        return view('admin.settings', compact('user'));
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

}
