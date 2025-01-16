<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
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
}
