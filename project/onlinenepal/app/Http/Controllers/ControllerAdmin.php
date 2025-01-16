<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\str;
use Illuminate\Support\Facades\File;
use Intervention\Image\Laravel\Facades\Image;

class ControllerAdmin extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function brands()
    {
        $brands = Brand::orderBy('id','DESC')->paginate(10);
        return view('admin.brands',compact('brands'));
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
            $brand -> name = $request->name;
            $brand -> slug = str::slug($request->name);
            $image = $request->file('image');
            $file_extension = $request->file('image')->extension();
            $file_name = Carbon::now()->timestamp.'.'.$file_extension;
            $this->SaveBrandImage($image, $file_name);
            $brand->image = $file_name;
            $brand-> save();
            return redirect()->route('admin.brands')->with('status','Brand ' . $request->name . " has been added successfully!");

        

    }

    public function SaveBrandImage($image, $filename)
    {
        $destination_path = public_path("uploads/brands");
        $img = Image::read($image->path());
        $img->cover(124,124,'top');
        $img->resize(124,124,function($constraint){
            $constraint ->aspectRatio();
        })->save($destination_path.'/'.$filename);
    }

    public function modify_brand($id)
    {
        $brand = Brand::find($id);
        return view('admin.brand-modify',compact('brand'));
    }

    public function brand_update(Request $request)
    {
        $request->validate(
            [
                'name' => 'required',
                'slug' => 'required|unique:brands,slug,'.$request->id,
                'image' => 'mimes:png,jpg|max:2048'
            ]
            );

            $brand = Brand::find($request->id);
            $brand -> name = $request->name;
            $brand -> slug = str::slug($request->name);
            if($request->hasFile('image'))
            {
                if(File::exists(public_path('uploads/brands').'/'.$brand->image)){
                    File::delete(public_path('uploads/brands').'/'.$brand->image);
                }
                $image = $request->file('image');
            $file_extension = $request->file('image')->extension();
            $file_name = Carbon::now()->timestamp.'.'.$file_extension;
            $this->SaveBrandImage($image, $file_name);
            $brand->image = $file_name;
            }
            $brand-> save();
            return redirect()->route('admin.brands')->with('status','Brand ' . $request->name . " has been updated successfully!");
    }

    public function remove_brand($id)
    {
        $brand = Brand::find($id);
        if(File::exists(public_path('uploads/brands').'/'.$brand->image)){
            File::delete(public_path('uploads/brands').'/'.$brand->image);
        }
        $brand_name = $brand-> name;
        $brand->delete();
        return view('admin.brands')->with('status','Brand ' . $brand_name . " has been deleted successfully!");;
    }

    public function category()
    {
        $category = Category::orderBy('id','DESC')->paginate(10);
        return view('admin.category',compact('category'));
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
            $cat -> name = $request->name;
            $cat -> slug = str::slug($request->name);
            $image = $request->file('image');
            $file_extension = $request->file('image')->extension();
            $file_name = Carbon::now()->timestamp.'.'.$file_extension;
            $this->SaveCategoryImage($image, $file_name);
            $cat->image = $file_name;
            $cat-> save();
            return redirect()->route('admin.category')->with('status','Category ' . $request->name . " has been added successfully!");

        

    }

    public function SaveCategoryImage($image, $filename)
    {
        $destination_path = public_path("uploads/category_images");
        $img = Image::read($image->path());
        $img->cover(124,124,'top');
        $img->resize(124,124,function($constraint){
            $constraint ->aspectRatio();
        })->save($destination_path.'/'.$filename);
    }


    public function modify_category($id)
    {
        $cat = Category::find($id);
        return view('admin.category_modify',compact('cat'));
    }

    public function category_update(Request $request)
    {
        $request->validate(
            [
                'name' => 'required',
                'slug' => 'required|unique:categories,slug,'.$request->id,
                'image' => 'mimes:png,jpg|max:2048'
            ]
            );

            $cat = Category::find($request->id);
            $cat -> name = $request->name;
            $cat -> slug = str::slug($request->name);
            if($request->hasFile('image'))
            {
                if(File::exists(public_path('uploads/category_images').'/'.$cat->image)){
                    File::delete(public_path('uploads/category_images').'/'.$cat->image);
                }
                $image = $request->file('image');
            $file_extension = $request->file('image')->extension();
            $file_name = Carbon::now()->timestamp.'.'.$file_extension;
            $this->SaveBrandImage($image, $file_name);
            $cat->image = $file_name;
            }
            $cat-> save();
            return redirect()->route('admin.category')->with('status','Category ' . $request->name . " has been updated successfully!");
    }

    public function remove_category($id)
    {
        $cat = Category::find($id);
        if(File::exists(public_path('uploads/category_images').'/'.$cat->image)){
            File::delete(public_path('uploads/category_images').'/'.$cat->image);
        }
        $cat_name = $cat-> name;
        $cat->delete();
        return view('admin.category')->with('status','Category ' . $cat_name . " has been deleted successfully!");;
    }

    public function products()
    {
        $products = Product::orderby('created_at','DESC')->paginate(10);
        return view('admin.products',compact('products'));
    }

    public function create_products()
    {
        $categories = Category::select('id','name')->orderBy('name')->get();
        $brands = Brand::select('id','name')->orderBy('name')->get();
        return view('admin.product_create',compact('categories','brands'));

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
            $product -> name = $request->name;
            $product -> slug = str::slug($request->name);
            $product -> short_description = $request->short_description;
            $product -> description = $request->description;
            $product -> regular_price = $request->regular_price;
            $product -> sales_price = $request->sale_price;
            $product -> SKU = $request->SKU;
            $product -> stock_status = $request->stock_status;
            $product -> featured = $request->featured;
            $product -> quantity = $request->quantity;
            $product -> category_id = $request->category_id;
            $product -> brand_id = $request->brand_id;
            $image = $request->file('image');
            $file_extension = $request->file('image')->extension();
            $file_name = Carbon::now()->timestamp.'.'.$file_extension;
            $this->SaveProductsImage($image, $file_name);
            $product->image = $file_name;
            $gallery_array = array();
            $gallery_images="";
            $counter = 1;
            if($request->hasFile('images'))
            {
                $allowedfileExtension = ['jpg','png','jpeg'];
                $files = $request->file('images');
                foreach($files as $file)
                {
                    $file_extension = $file->getClientOriginalExtension();
                    $check = in_array($file_extension,$allowedfileExtension);
                    if($check)
                    {
                        $file_name = Carbon::now()->timestamp . '_' . uniqid() . '_' . $counter . '.' . $file_extension;
                        $this->SaveProductsImage($file, $file_name);
                        array_push($gallery_array,$file_name );
                        $counter++;

                    }
                    
                }
                $gallery_images = implode(',',$gallery_array);
            }
            $product->images = $gallery_images;
            $product-> save();
            return redirect()->route('admin.products')->with('status','Product ' . $request->name . " has been added successfully!");

        

    }

    public function SaveProductsImage($image, $filename)
    {
        $destination_path = public_path("uploads/products");
        $img = Image::read($image->path());
        $img->cover(540,689,'top');
        $img->resize(540,689,function($constraint){
            $constraint ->aspectRatio();
        })->save($destination_path.'/'.$filename);
    }

    public function modify_products($id)
    {
        $product = Product::find($id);
        $categories = Category::select('id','name')->orderBy('name')->get();
        $brands = Brand::select('id','name')->orderBy('name')->get();
        return view('admin.products_modify',compact('product','categories','brands'));
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



}
