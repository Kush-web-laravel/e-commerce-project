<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductsController;
use App\Http\Controllers\Api\SubcategoryController;
use App\Http\Controllers\Api\OrdersController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('register', [AuthController::class, 'register']);
Route::post('verify-register-otp', [AuthController::class, 'verifyRegisterOtp']);
Route::post('login', [AuthController::class, 'login']);
Route::post('verify-login-otp', [AuthController::class, 'verifyLoginOtp']);
Route::post('forgot-password', [AuthController::class, 'forgotPassword']);

Route::middleware('auth:sanctum')->group(function(){
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('updateProfile', [AuthController::class, 'updateProfile']);
    Route::post('changePassword', [AuthController::class, 'changePassword']);
    Route::get('categoryList', [CategoryController::class, 'categoryList']);
    Route::get('subCategoryList', [SubcategoryController::class, 'subCategoryList']);
    Route::get('productList', [ProductsController::class, 'productList']);
    Route::post('addToCart', [ProductsController::class, 'addToCart']);
    Route::get('listCart', [ProductsController::class, 'listCart']);
    Route::post('removeFromCart', [ProductsController::class, 'removeFromCart']);
    Route::post('placeOrders', [OrdersController::class, 'placeOrders']);
    Route::get('orderDetails', [OrdersController::class, 'orderDetails']);
});
