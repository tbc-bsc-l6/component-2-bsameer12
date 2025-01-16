<?php

use App\Http\Controllers\ControllerAdmin;
use App\Http\Controllers\ControllerUser;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Middleware\AdminAuthentication;
use Illuminate\Support\Facades\Auth;

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home.index');


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
    
});