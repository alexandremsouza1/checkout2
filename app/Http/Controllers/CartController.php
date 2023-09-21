<?php

namespace App\Http\Controllers;

use App\Facades\Customer;
use App\Facades\Product;
use App\Http\Requests\CartRequest;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use App\Services\CartService;
use App\Services\CustomerService;
use App\Services\ProductService;
use Illuminate\Http\Request;

class CartController extends Controller
{

    private $customerService;

    private $productService;

    private $cartService;


    public function __construct(CustomerService $customerService, ProductService $productService, CartService $cartService)
    {
        $this->customerService = $customerService;
        $this->productService = $productService;
        $this->cartService = $cartService;
    }

    /***************************************************************************************
     ** GET
     ***************************************************************************************/
    public function get(Cart $cart)
    {
        return $this->success(new CartResource($cart->load(['cartItems.product', 'customer','order'])));
    }

    /***************************************************************************************
     ** POST
     ***************************************************************************************/
    public function create(CartRequest $request)
    {
        $addItems = [];
        $customer = $this->customerService->getOrCreateCustomer($request->customer);
        foreach ($request->items as $item) {
            $product = $this->productService->getOrCreateProduct($item);
            $addItems[] = [
                'product_id' => $product->id,
                'quantity' => $item['quantity'],
                'price' => $product->price,
            ];
        }
        $cart = $this->cartService->getOrCreateCart($customer, $addItems, $request);


        return $this->success(new CartResource($cart->fresh()->load(['cartItems.product', 'customer','order'])));
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
