<?php

namespace App\Http\Controllers;

use App\Facades\Customer;
use App\Facades\Product;
use App\Http\Requests\CartRequest;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use App\Services\CustomerService;
use App\Services\ProductService;
use Illuminate\Http\Request;

class CartController extends Controller
{

    private $customerService;

    private $productService;


    public function __construct(CustomerService $customerService, ProductService $productService)
    {
        $this->customerService = $customerService;
        $this->productService = $productService;
    }

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
        $customerForeignKey = $this->customerService->getOrCreateCustomer($request->customer)->getForeignKey();
        $productForeignKey = $this->productService->getOrCreateProduct($request->item)->getForeignKey();

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
