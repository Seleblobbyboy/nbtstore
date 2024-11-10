<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\productController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SearchController;
use Illuminate\Http\Request;



Route::get('/admin', [AdminController::class, "index"])->middleware('admin');


Route::get('/admin/success/{id}', [AdminController::class, "success"])->middleware('admin');
Route::get('/admin/confirm/{id}', [AdminController::class, "confirm"])->middleware('admin');
Route::get('/admin/notConfirm/{id}', [AdminController::class, "notConfirm"])->middleware('admin');
Route::post('/save-comment', [AdminController::class, 'saveComment'])->name('save-comment');

Route::get('/admin/add_product', [AdminController::class, "add_product"])->middleware('admin');
Route::post('/add_products', [AdminController::class, "add_products"])->middleware('admin');
Route::put('/update_products/{productId}', [AdminController::class, 'update_products'])->middleware('admin');
Route::get('/edit_products/{id}', [AdminController::class, "edit_products"])->middleware('admin');
Route::get('/delete_products/{id}', [AdminController::class, "delete_products"])->middleware('admin');
Route::get('/product', [AdminController::class, "product"])->middleware('admin');
Route::get('/categories', [AdminController::class, "categories"])->middleware('admin');
Route::get('/edit_categories/{id}', [AdminController::class, "edit_categories"])->middleware('admin');
Route::post('/update_categories/{id}', [AdminController::class, "update_categories"])->middleware('admin');
Route::get('/delete_categories/{id}', [AdminController::class, "delete_categories"])->middleware('admin');
Route::post('/add_categories', [AdminController::class, "add_categories"])->middleware('admin');


Route::get('/', [HomepageController::class, "index"]);


Route::get('/product/{id}', [productController::class, "index"]);


Route::get('/cart', [CartController::class, "index"]);
Route::post('/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/update/{id}', [CartController::class, 'updateCart'])->name('cart.update');
Route::delete('/cart/remove/{id}', [CartController::class, 'removeFromCart']);
Route::put('/cart/updateTotalQuantity', [CartController::class, 'updateTotalQuantity']);
Route::put('/cart/updateTotalQuantityAndAmount', [CartController::class, 'updateTotalQuantityAndAmount']);


Route::get('/cart/shopping', [CartController::class, "shopping"])->middleware('users')->name('cart.shopping');
Route::get('/cart/payment', [CartController::class, "payment"])->middleware('address')->name('cart.payment');

Route::get('/cart/success/{id}', [CartController::class, "success"])->middleware(['checkorder', 'address'])->name('cart.success.blade');



Route::post('/store-customer-info', [CustomerController::class, 'storeCustomerInfo'])->name('store.customer.info');
Route::get('/customer/{id}', [CustomerController::class, 'destroy'])->name('customer.destroy');
Route::get('/cart/address/{id}', [CustomerController::class, 'SelectAddress']);

Route::post('/placeOrder', [CartController::class, "placeOrder"])->middleware('users')->name('cart.checkout');
Route::post('/orders/uploadSlip/{order}', [CartController::class, 'uploadSlip'])->name('orders.uploadSlip');

Route::post('/orders/editloadSlip/{order}', [CartController::class, 'editloadSlip'])->name('orders.editloadSlip');



Route::get('/profile', [UserController::class, 'User'])->middleware('users');
Route::get('/profile/order', [UserController::class, 'order'])->middleware('users');


Route::get('/profile/check/{id}', [UserController::class, 'success'])->middleware('users')->name('profile.check');



Route::get('/login', [LoginController::class, "login"]);
Route::get('/logout', [LoginController::class, "logout"]);
Route::get('/logout/admin', [LoginController::class, "logout_admin"]);
Route::get('/forgot', [LoginController::class, "forgot"]);
Route::get('/reset', [LoginController::class, "reset"]);

Route::post('/forgot/check', [LoginController::class, "check_forgot"]);
Route::post('/reset/check', [LoginController::class, "check_reset"]);
Route::post('/login/add', [LoginController::class, "add"]);
Route::post('/register/add', [LoginController::class, "add_register"]);

Route::post('login/check', [LoginController::class, "check"]);

Route::get('/register', [LoginController::class, "register"]);



Route::post('/profile/order/searchr', [SearchController::class, "SearchrStatus"]);



// Route::get('/', function () {
//     return view('welcome');
// });


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
