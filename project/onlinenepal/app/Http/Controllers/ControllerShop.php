<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ControllerShop extends Controller
{
    public function index(Request $request)
    {
        $size = $request->query('size') ? (int)$request->query('size') : 12;
        $order_column = "";
        $order_order = "";
        $order = $request->query('order') ? (int)$request->query('order') : -1;
        $brand_fliter = $request->query('brands') ;
        $categories_fliter = $request->query('categories') ;
        $minimum_price = $request->query('min') ? $request->query('min') : 1;
        $maximum_price = $request->query('max') ? $request->query('max') : 1000000;
        switch($order)
        {
            case 6:
                $order_column = "created_at";
                $order_order = "DESC";
                break;

            case 5:
                $order_column = "created_at";
                $order_order = "ASC";
                break;
            
            case 1:
                $order_column = "name";
                $order_order = "ASC";
                break;
            
            case 2:
                $order_column = "name";
                $order_order = "DESC";
                break;
            
            case 3:
                $order_column = "sales_price";
                $order_order = "ASC";
                break;

            case 4:
                $order_column = "sales_price";
                $order_order = "DESC";
                break;

            default:
            $order_column = "id";
            $order_order = "DESC";
        }
        $brands = Brand::orderBy('name','ASC')->get();
        $categories = Category::orderBy('name','ASC')->get();
        $products  = Product::where(function($query)use($brand_fliter){$query->whereIn('brand_id',explode(',',$brand_fliter))->orWhereRaw("'".$brand_fliter."'=''");})->where(function($query)use($categories_fliter){$query->whereIn('category_id',explode(',',$categories_fliter))->orWhereRaw("'".$categories_fliter."'=''");})->where(function($query) use($minimum_price,$maximum_price){$query->WhereBetween('regular_price',[$minimum_price,$maximum_price])->OrWhereBetween('sales_price',[$minimum_price,$maximum_price]);})->orderBy($order_column , $order_order )->paginate($size);
        return view('shop',compact('products', 'size','order','brands','brand_fliter','categories','categories_fliter','minimum_price','maximum_price'));
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
