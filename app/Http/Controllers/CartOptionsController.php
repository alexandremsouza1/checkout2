<?php

namespace App\Http\Controllers;

use App\Http\Resources\CartOptionsRequest;
use App\Http\Resources\CartResource;
use App\Models\Cart;

class CartOptionsController extends Controller
{
    public function store(Cart $cart, CartOptionsRequest $request)
    {
        $cart->addOptions($request->validated()['options']);

        return $this->success(new CartResource($cart->load('cartItems.product')));
    }
}
