<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductsController;
use App\Http\Controllers\Api\SubcategoryController;
use App\Http\Controllers\Api\OrdersController;

Route::post('sendOtp', [AuthController::class, 'sendOtp']);
Route::post('verifyOtp', [AuthController::class, 'verifyOtp']);
Route::post('/validate-phone', 'PhoneController@validatePhone');

Route::middleware('auth:sanctum')->group(function(){
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('updateProfile', [AuthController::class, 'updateProfile']);
    Route::get('categoryList', [CategoryController::class, 'categoryList']);
    Route::get('subCategoryList', [SubcategoryController::class, 'subCategoryList']);
    Route::get('productList', [ProductsController::class, 'productList']);
    Route::post('addToCart', [ProductsController::class, 'addToCart']);
    Route::get('listCart', [ProductsController::class, 'listCart']);
    Route::post('removeFromCart', [ProductsController::class, 'removeFromCart']);
    Route::post('placeOrders', [OrdersController::class, 'placeOrders']);
    Route::get('orderDetails', [OrdersController::class, 'orderDetails']);
    Route::get('invoice', [OrdersController::class, 'showInvoice']);
});
