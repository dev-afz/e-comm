<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\Orders\OrdersController as OrdersOrdersController;
use App\Http\Controllers\Orders\ViewOrdersController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\OrderStatusController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RazorpayController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserOrderController;
use App\Http\Controllers\ViewProductController;
use GuzzleHttp\Middleware;
use Illuminate\Auth\Middleware\IsAdmin;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['admin']], function () {
    Route::get('/', function () {
        return view('layouts.welcome');
    });
    Route::controller(ProductController::class)->prefix('product')->name('product.')->group(function () {
        Route::get('index', 'index')->name('index');
        Route::post('/store', 'store')->name('store');
        Route::get('edit', 'edit')->name('edit');
        Route::post('update', 'update')->name('update');
        Route::get('delete', 'delete')->name('delete');
        Route::get('changestatus/', 'updatestatus')->name('changestatus');
    });
    //Order detail route
    Route::controller(ViewOrdersController::class)->prefix('order')->name('order.')->group(function () {
        Route::get('pending', 'pendingOrder')->name('pending');
        Route::get('accepted', 'acceptedOrder')->name('accepted');
        Route::get('shipped', 'shippedOrder')->name('shipped');
        Route::get('delivered', 'deliveredOrder')->name('delivered');
        Route::get('cancelled', 'cancelledOrder')->name('cancelled');
        Route::get('orderstatus/', 'updateStatus')->name('orderstatus');
    });
    Route::controller(ViewProductController::class)->prefix('product')->name('product.')->group(function () {
        Route::get('view', 'index')->name('view');
        Route::get('deleted', 'deleted')->name('deleted');
    });
    Route::get('view-user', [UserController::class, 'index'])->name('view-user');
    Route::controller(OrderStatusController::class)->group(function () {
        Route::post('tracking-status', 'trackingstatus')->name('trackingstatus');
    });

    //coupons section
    Route::controller(CouponController::class)->prefix('coupons')->name('coupon.')->group(function () {
        Route::get('index', 'index')->name('index');
        Route::post('addCoupon', 'store')->name('addCoupon');
        Route::get('edit', 'edit')->name('edit');
        Route::post('update', 'updateCoupon')->name('update');
        Route::get('delete/{id}', 'delete')->name('delete');
    });
});
//Unauthorized page route
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//Login routes
Route::controller(AuthController::class)->group(function () {
    Route::get('/unauthorized', 'unauthorized')->name('unauthorized');
    Route::get('/login', 'index')->name('login');
    Route::post('post-login', 'postLogin')->name('post-login');
    Route::get('registration', 'registration')->name('registration');
    Route::post('post-register', 'postregistration')->name('post-register');
    Route::get('logout', 'logout')->name('logout');
});
//Orders routes
Route::group(['middleware' => ['auth']], function () {
    Route::controller(OrdersController::class)->group(function () {
        Route::get('order-detail/{product}', 'index')->name('order-detail');
        Route::post('create-order', 'placeorder')->name('create-order');
        Route::get('checkout-payment', 'paymentDetail')->name('checkout-payment');
    });
    Route::controller(UserOrderController::class)->prefix('user-order')->name('user-order')->group(function () {
        Route::get('order-list/{id?}', 'index')->name('order-list');
        Route::get('show/{id}', 'showorderdetails')->name('show');
        Route::get('unpaid/{id}', 'unpaidorder')->name('unpaid');
    });

    Route::controller(CartController::class)->group(function () {
        Route::get('cart', 'index')->name('cart');
        Route::post('addtocart', 'store')->name('addtocart');
        Route::post('delete-cart-item', 'deletecartitem')->name('delete-cart-item');
    });


    Route::controller(RazorpayController::class)->group(function () {
        Route::get('razorpay-payment/{id}', 'index')->name('razorpay-payment');
        Route::post('razorpay-payment', 'store')->name('razorpay.payment.store');
    });
});
