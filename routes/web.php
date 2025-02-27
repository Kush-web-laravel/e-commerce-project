<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\InstagramController;
use App\Http\Controllers\PhoneCheckController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Route::get('login', [LoginController::class, 'login'])->name('login-view');
Route::post('login', [LoginController::class, 'adminLogin'])->name('login');
Route::get('forgotPassword', [LoginController::class, 'forgotPasswordView'])->name('forgotPassword-view');
Route::post('forgotPassword', [LoginController::class, 'forgotPassword'])->name('forgotPassword');
Route::get('instagram', [InstagramController::class, 'showData'])->name('instagramData');
// Route::get('phone-auth', function(){
//     return view('phone-auth');
// });
Route::get('phone-auth', function(){
    return view('phone-auth-2');
});
// Route::post('/setToken', function (Request $request) {
//     // Validate request data
//     $request->validate([
//         'id' => 'required',
//         'userId' => 'required',
//         'email' => 'required'
//     ]);

//     // Fake authentication logic
//     return response()->json(['access' => true]);
// })->name('setToken');
// Route::post('/validate-phone', [PhoneCheckController::class, 'validatePhone'])->name('validate.phone');
// Route::get('/phone-auth', [PhoneCheckController::class, 'showPhoneAuthForm'])->name('phone.auth');
Route::middleware('auth:admin')->group(function(){
    Route::get('dashboard', [LoginController::class, 'dashboard'])->name('dashboard-view');
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('changePassword', [LoginController::class, 'changePasswordView'])->name('changePassword-view');
    Route::post('verifyCurrentPassword', [LoginController::class, 'verifyCurrentPassword'])->name('verifyCurrentPassword');
    Route::post('changePassword', [LoginController::class, 'changePassword'])->name('changePassword');

    Route::get('profile', [LoginController::class, 'profileView'])->name('profile-view');
    Route::post('updateProfile', [LoginController::class, 'updateProfile'])->name('profile');

    Route::get('sub-admin', [LoginController::class, 'subAdminList'])->name('subAdmin-view');
    Route::get('addSubAdmin', [LoginController::class, 'addSubAdmin'])->name('addSubAdmin-view');
    Route::post('addSubAdmin', [LoginController::class, 'subAdminStore'])->name('addSubAdmin');
    Route::get('editSubAdmin/{id}', [LoginController::class, 'editSubAdmin'])->name('editSubAdmin');
    Route::post('updateSubAdmin/{id}', [LoginController::class, 'updateSubAdmin'])->name('updateSubAdmin');
    Route::delete('deleteSubAdmin/{id}', [LoginController::class, 'deleteSubAdmin'])->name('deleteSubAdmin');
    
    Route::prefix('categories')->group(function(){
        Route::get('/', [CategoryController::class, 'index'])->name('category-view');
        Route::get('add', [CategoryController::class, 'add'])->name('addCategory-view');
        Route::post('add', [CategoryController::class, 'store'])->name('addCategory');
        Route::get('edit/{id}', [CategoryController::class, 'edit'])->name('editCategory');
        Route::post('update/{id}', [CategoryController::class, 'update'])->name('updateCategory');
        Route::post('delete/{id}', [CategoryController::class, 'delete'])->name('deleteCategory');
    });

    Route::prefix('subcategories')->group(function(){
        Route::get('/', [SubCategoryController::class, 'index'])->name('subcategory-view');
        Route::get('add', [SubCategoryController::class, 'add'])->name('addSubCategory-view');
        Route::post('add', [SubCategoryController::class, 'store'])->name('addSubCategory');
        Route::get('edit/{id}', [SubCategoryController::class, 'edit'])->name('editSubCategory');
        Route::post('update/{id}', [SubCategoryController::class, 'update'])->name('updateSubCategory');
        Route::post('delete/{id}', [SubCategoryController::class, 'delete'])->name('deleteSubCategory');
    });

    Route::prefix('products')->group(function(){
        Route::get('/', [ProductsController::class, 'index'])->name('product-view');
        Route::get('add', [ProductsController::class, 'add'])->name('addProduct-view');
        Route::post('add', [ProductsController::class, 'store'])->name('addProduct');
        Route::get('edit/{id}', [ProductsController::class, 'edit'])->name('editProduct');
        Route::post('update/{id}', [ProductsController::class, 'update'])->name('updateProduct');
        Route::post('delete/{id}', [ProductsController::class, 'delete'])->name('deleteProduct');
        Route::get('/get-subcategories/{categoryId}', [ProductsController::class, 'getSubcategories'])->name('getSubcategories');
    });

    Route::prefix('orders')->group(function(){
        Route::get('/', [OrdersController::class, 'index'])->name('orders-view');
        Route::get('order-details/{id}', [OrdersController::class, 'orderDetails'])->name('orderDetails');
        Route::post('order-status/{id}', [OrdersController::class, 'changeOrderStatus'])->name('changeOrderStatus');
        Route::get('invoice/{id}', [OrdersController::class, 'showInvoice'])->name('invoice');
        Route::get('detailsForStatusModal/{id}', [OrdersController::class, 'detailsForStatusModal'])->name('detailsForStatusModal');
        Route::post('/attach-delivery-slip', [OrdersController::class, 'attachDeliverySlip'])->name('attachSlip');

    });

    
});