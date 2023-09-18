<?php

namespace App\Http\Controllers;

use App\Http\Resources\CartCouponRequest;
use App\Http\Resources\CartResource;
use App\Models\Cart;

class CartCouponController extends Controller
{
    /***************************************************************************************
     ** PUT
     ***************************************************************************************/
    public function update(Cart $cart, CartCouponRequest $request)
    {
        $cart->addCoupon($request->validated());

        return $this->success(new CartResource($cart->load(['cartItems.product', 'order'])));
    }

    public function delete(Cart $cart)
    {
        $cart->removeCoupon();

        return $this->success(new CartResource($cart->load(['cartItems.product', 'order'])));
    }
}
