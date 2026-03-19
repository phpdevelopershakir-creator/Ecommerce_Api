<?php

use App\Http\Controllers\admin\AuthController;
use App\Http\Controllers\front\AccountController;
use App\Http\Controllers\front\OrderController;
use App\Http\Controllers\front\ProductController as FrontProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/admin/login', [AuthController::class, 'authenticate']);
Route::get('get-latest-products', [FrontProductController::class, 'latetstProducts']);
Route::get('get-featured-products', [FrontProductController::class, 'featuredProducts']);
Route::get('get-categories', [FrontProductController::class, 'getCategories']);
Route::get('get-brands', [FrontProductController::class, 'getBrands']);
Route::get('get-products', [FrontProductController::class, 'getProducts']);
Route::get('get-product/{id}', [FrontProductController::class, 'getProduct']);

Route::post('/account/register', [AccountController::class, 'register']);
Route::post('/account/login', [AccountController::class, 'login']);


Route::middleware(['auth:sanctum', 'checkUserRole'])->group(function () {
    Route::post('/order-save', [OrderController::class, 'OrderSave']);
    Route::get('get-orders', [AccountController::class, 'getOrders']);
    Route::get('get-order-details/{id}', [AccountController::class, 'getOrderDetails']);
});


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::middleware(['auth:sanctum', 'checkAdminRole'])->prefix('admin')->group(function () {

    Route::apiResource('categories', App\Http\Controllers\admin\CategoryController::class);
    Route::apiResource('brands', App\Http\Controllers\admin\BrandController::class);
    Route::apiResource('colors', App\Http\Controllers\admin\ColorControloler::class);
    Route::apiResource('sizes', App\Http\Controllers\admin\SizeControloler::class);
    Route::apiResource('products', App\Http\Controllers\admin\ProductController::class);
    Route::post('temp-images', [App\Http\Controllers\admin\TempImagecontroller::class, 'store']);
    Route::post('save-product-image', [App\Http\Controllers\admin\ProductController::class, 'saveProductImage']);
    Route::get('change-product-default-image', [App\Http\Controllers\admin\ProductController::class, 'updateDefaultImage']);
    Route::delete('product-image-delete/{id}', [App\Http\Controllers\admin\ProductController::class, 'deleteProductImage']);
    Route::get('orders', [App\Http\Controllers\admin\AdminOrderController::class, 'AdminOrder']);
    Route::get('orders/{id}', [App\Http\Controllers\admin\AdminOrderController::class, 'AdminOrderDetails']);
    Route::post('update-order/{id}', [App\Http\Controllers\admin\AdminOrderController::class, 'updateOrder']);
});
