<?php

namespace App\Http\Controllers;

use App\Http\Resources\CartItemRequest;
use App\Http\Resources\CartItemResource;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;

class CartItemController extends Controller
{
    /***************************************************************************************
     ** POST
     ***************************************************************************************/
    public function create(CartItemRequest $request, Cart $cart)
    {
        CartItem::makeOne($cart, $request->validated());

        $cart = $cart->fresh();
        $cart->load('cartItems.product');

        return $this->success(new CartResource($cart));
    }

    /***************************************************************************************
     ** PUT
     ***************************************************************************************/
    public function update(CartItem $cartItem, CartItemRequest $request)
    {
        $cartItem->updateMe($request->validated());
        $cart = $cartItem->cart;
        $cart->load('cartItems.product');

        return $this->success(new CartResource($cart));
    }

    /***************************************************************************************
     ** DELETE
     ***************************************************************************************/
    public function delete(CartItem $cartItem)
    {
        $cartItem->delete();

        return $this->success();
    }
}
