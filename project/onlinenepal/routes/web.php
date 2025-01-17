<?php

use App\Http\Controllers\ControllerAdmin;
use App\Http\Controllers\ControllerCart;
use App\Http\Controllers\ControllerShop;
use App\Http\Controllers\ControllerUser;
use App\Http\Controllers\ControllerWishlist;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Middleware\AdminAuthentication;
use Illuminate\Support\Facades\Auth;

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/shop', [ControllerShop::class, 'index'])->name('shop.index');
Route::get('/shop/{product_slug}', [ControllerShop::class, 'details_product'])->name('shop.product.details');

Route::get('/cart}', [ControllerCart::class, 'index'])->name('cart.index');
Route::post('/cart/add', [ControllerCart::class, 'add_to_cart'])->name('cart.add');
Route::put('/cart/update-quantity-increase/{rowId}', [ControllerCart::class, 'cart_quantity_increase'])->name('cart.quantity.increase');
Route::put('/cart/update-quantity-decrease/{rowId}', [ControllerCart::class, 'cart_quantity_decrease'])->name('cart.quantity.decrease');
Route::delete('/cart/delete/{rowId}', [ControllerCart::class, 'cart_item_remove'])->name('cart.delete');
Route::delete('/cart/clear', [ControllerCart::class, 'cart_empty'])->name('cart.clear');
Route::post('/cart/apply-coupon', [ControllerCart::class, 'coupons_apply_to_cart'])->name('cart.apply.coupon');
Route::delete('/cart/remove-coupon', [ControllerCart::class, 'delete_coupon_code'])->name('cart.remove.coupon');

Route::post('/wishlist/add', [ControllerWishlist::class, 'add_to_wishlist'])->name('wishlist.add');
Route::get('/wishlist}', [ControllerWishlist::class, 'index'])->name('wishlist.index');
Route::delete('/wishlist/delete/{rowId}', [ControllerWishlist::class, 'wishlist_item_remove'])->name('wishlist.delete');
Route::delete('/wishlist/clear', [ControllerWishlist::class, 'wishlist_empty'])->name('wishlist.clear');
Route::post('/wishlist/move-to-cart/{rowId}', [ControllerWishlist::class, 'wishlist_to_cart'])->name('wishlist.move.to.cart');

Route::middleware(['auth'])->group(function(){
    Route::get('/account-dashboard',[ControllerUser::class, 'index'])->name('user.index');
});


Route::middleware(['auth', AdminAuthentication::class])->group(function(){
    Route::get('/admin',[ControllerAdmin::class, 'index'])->name('admin.index');
    Route::get('/admin/brands',[ControllerAdmin::class, 'brands'])->name('admin.brands');
    Route::get('/admin/brand/add',[ControllerAdmin::class, 'add_brand'])->name('admin.brand.add');
    Route::post('/admin/brand/save',[ControllerAdmin::class, 'save_brand'])->name('admin.brand.save');
    Route::get('/admin/brand/modify/{id}',[ControllerAdmin::class, 'modify_brand'])->name('admin.brand.modify');
    Route::put('/admin/brand/update',[ControllerAdmin::class, 'brand_update'])->name('admin.brand.update');
    Route::delete('/admin/brand/remove/{id}',[ControllerAdmin::class, 'remove_brand'])->name('admin.brand.remove');


    Route::get('/admin/category',[ControllerAdmin::class, 'category'])->name('admin.category');
    Route::get('/admin/category/create',[ControllerAdmin::class, 'create_category'])->name('admin.category.create');
    Route::post('/admin/category/save',[ControllerAdmin::class, 'save_category'])->name('admin.category.save');
    Route::get('/admin/category/modify/{id}',[ControllerAdmin::class, 'modify_category'])->name('admin.category.modify');
    Route::put('/admin/category/update',[ControllerAdmin::class, 'category_update'])->name('admin.category.update');
    Route::delete('/admin/category/remove/{id}',[ControllerAdmin::class, 'remove_category'])->name('admin.category.remove');


    Route::get('/admin/products',[ControllerAdmin::class, 'products'])->name('admin.products');
    Route::get('/admin/products/create',[ControllerAdmin::class, 'create_products'])->name('admin.products_create');
    Route::post('/admin/products/save',[ControllerAdmin::class, 'save_products'])->name('admin.products.save');
    Route::get('/admin/products/modify/{id}',[ControllerAdmin::class, 'modify_products'])->name('admin.products.modify');
    Route::put('/admin/products/update',[ControllerAdmin::class, 'update_product'])->name('admin.products.update');
    Route::delete('/admin/products/remove/{id}',[ControllerAdmin::class, 'remove_product'])->name('admin.products.remove');

    Route::get('/admin/coupons',[ControllerAdmin::class, 'coupons'])->name('admin.coupons');
    Route::get('/admin/coupons/add',[ControllerAdmin::class, 'coupons_add'])->name('admin.coupons.add');
    Route::post('/admin/coupons/save',[ControllerAdmin::class, 'save_coupon'])->name('admin.coupons.save');
    Route::get('/admin/coupons/modify/{id}',[ControllerAdmin::class, 'modify_coupon'])->name('admin.coupons.modify');
    Route::put('/admin/coupons/update',[ControllerAdmin::class, 'coupon_update'])->name('admin.coupons.update');
    Route::delete('/admin/coupons/remove/{id}',[ControllerAdmin::class, 'remove_coupon'])->name('admin.coupons.remove');

    
});