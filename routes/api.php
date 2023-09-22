<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CartItemController;
use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/***************************************************************************************
 ** Cart
 ***************************************************************************************/

Route::get('/carts', [CartController::class, 'get']);
Route::post('/carts', [CartController::class, 'create']); //carts.create'
Route::put('/carts', [CartController::class, 'update']); //carts.update'
Route::delete('/carts', [CartController::class, 'delete']); //carts.delete'

Route::put('/carts/zipcode', [CartZipCodeController::class, 'update']); //carts.zipcode.update'
Route::put('/carts/shipping', [CartShippingController::class, 'update']); //carts.shipping.update'
Route::put('/carts/email', [CartEmailController::class, 'update']); //carts.email.update'
Route::post('/carts/options', [CartOptionsController::class, 'store']); //carts.options.store'

Route::put('/carts/coupon-code', [CartCouponController::class, 'update']); //carts.coupon.update'
Route::delete('/carts/coupon-code', [CartCouponController::class, 'delete']); //carts.coupon.delete'

/***************************************************************************************
 ** Cart Items
 ***************************************************************************************/

Route::post('/carts/cart-items/{code}', [CartItemController::class, 'create']); //carts.cartitems.create'
Route::put('/carts/cart-items/{code}', [CartItemController::class, 'update']); //cartitems.update'
Route::delete('/carts/cart-items/{code}', [CartItemController::class, 'delete']); //cartitems.delete'

/***************************************************************************************
 ** Checkout
 ***************************************************************************************/

Route::get('/checkout/settings', [CheckoutSettingsController::class, 'index']); //checkout.settings'

/***************************************************************************************
 ** Orders
 ***************************************************************************************/

Route::get('/orders/{order}', [OrderController::class, 'get']); //orders.get'
Route::post('/orders', [OrderController::class, 'create']); //orders.create'
