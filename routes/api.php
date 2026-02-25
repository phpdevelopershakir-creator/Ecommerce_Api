<?php

use App\Http\Controllers\admin\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/admin/login', [AuthController::class, 'authenticate']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->prefix('admin')->group(function () {

    Route::apiResource('categories', App\Http\Controllers\admin\CategoryController::class);
    Route::apiResource('brands', App\Http\Controllers\admin\BrandController::class);
    Route::apiResource('colors', App\Http\Controllers\admin\ColorControloler::class);
    Route::apiResource('sizes', App\Http\Controllers\admin\SizeControloler::class);
    Route::apiResource('products', App\Http\Controllers\admin\ProductController::class);
    Route::post('temp-images',[App\Http\Controllers\admin\TempImagecontroller::class,'store']);
    Route::post('save-product-image',[App\Http\Controllers\admin\ProductController::class,'saveProductImage']);
    Route::get('change-product-default-image',[App\Http\Controllers\admin\ProductController::class,'updateDefaultImage']);
});
