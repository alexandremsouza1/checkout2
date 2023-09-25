<?php

namespace App\Http\Controllers;

use App\Http\Resources\CartZipCodeRequest;
use App\Http\Resources\CartResource;
use App\Models\Cart;

class CartZipCodeController extends Controller
{
    public function update(Cart $cart, CartZipCodeRequest $request)
    {
        $cart->updateZipCode($request->validated());

        return $this->success(new CartResource($cart->load('cartItems.product')));
    }
}
