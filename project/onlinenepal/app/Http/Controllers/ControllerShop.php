<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ControllerShop extends Controller
{
    public function index()
    {
        $products  = Product::orderBy('created_at','DESC')->paginate(12);
        return view('shop',compact('products'));
    }

    public function details_product($product_slug)
    {
            $product = Product::where('slug', $product_slug)->first();

            if (!$product) {
                abort(404, 'Product not found'); // Handle the case where the product does not exist
            }

            $otherProducts = Product::where('slug', '!=', $product_slug)
                        ->where('category_id', $product->category_id)
                        ->take(10)
                        ->get();


            return view('product_detail', compact('product','otherProducts'));
    }

}
