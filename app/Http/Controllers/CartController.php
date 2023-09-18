<?php

namespace App\Http\Controllers;

use App\Facades\Customer;
use App\Facades\Product;
use App\Http\Requests\CartRequest;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /***************************************************************************************
     ** GET
     ***************************************************************************************/
    public function get(Cart $cart)
    {
        return $this->success(new CartResource($cart->load(['cartItems.product', 'order'])));
    }

    /***************************************************************************************
     ** POST
     ***************************************************************************************/
    public function create(CartRequest $request)
    {
        $customerForeignKey = 1;//Customer::getForeignKey();
        $productForeignKey = 1;//Product::getForeignKey();

        $cart = Cart::makeOne([
            $customerForeignKey => auth()->user()->id ?? null,
            'ip_address' => $request->ip(),
            $productForeignKey => $request->get($productForeignKey)
        ]);

        return $this->success(new CartResource($cart->fresh()->load(['cartItems.product', 'order'])));
    }

    /***************************************************************************************
     ** PUT
     ***************************************************************************************/
    public function update(Cart $cart, CartRequest $request)
    {
        $cart->updateMe($request->validated());

        return $this->success(new CartResource($cart->load(['cartItems.product', 'order'])));
    }

    /***************************************************************************************
     ** DELETE
     ***************************************************************************************/
    public function delete(Cart $cart)
    {
        $cart->delete();

        return $this->success();
    }
}
