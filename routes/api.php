<?php

use App\Http\Controllers\CartController;
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

Route::group(['prefix' => 'cart'], function () {

  Route::post('/add/{user}',[CartController::class,'add']);
  Route::get('/{user}',[CartController::class,'index']);

});


Route::group(['prefix' => 'checkout'], function () {
  // GET /checkout
  Route::get('/',  [CheckoutController::class,'index']);
  // PATCH /checkout/payment-method/{id}/{condicao}
  Route::patch('/payment-method/{id}/{condition}', [CheckoutController::class,'updatePaymentMethod']);
  // POST /checkout (executa pagamento)
  Route::post('/', [CheckoutController::class,'checkout']);
});