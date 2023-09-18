<?php

namespace App\Http\Controllers;

use App\Http\Resources\CartEmailRequest;
use App\Http\Resources\CartResource;
use App\Models\Cart;

class CartEmailController extends Controller
{
    public function update(Cart $cart, CartEmailRequest $request)
    {
        $cart->updateEmail($request->validated());

        return $this->success(new CartResource($cart->load('cartItems.product')));
    }
}
