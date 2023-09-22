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

    private $productService;

    private $cartService;


    public function __construct(ProductService $productService, CartService $cartService)
    {
        $this->productService = $productService;
        $this->cartService = $cartService;
    }

    /***************************************************************************************
     ** GET
     ***************************************************************************************/
    public function get(CartRequest $request)
    {
        $cart = $this->cartService->findCart($request->validated());
        if(!$cart) {
            return $this->error([],'Esse usuário não possui carrinho ativo.');
        }
        return $this->success(new CartResource($cart->load(['cartItems.product', 'order'])));
    }

    /***************************************************************************************
     ** POST
     ***************************************************************************************/
    public function create(CartRequest $request)
    {
        $addItems = [];
        $data = $request->validated();
        if(isset($data['items'])) {
            foreach ($data['items'] as $item) {
                $product = $this->productService->getOrCreateProduct($data['clientId'],$item);
                $addItems[] = [
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                ];
            }
        }
        $data['items'] = $addItems;
        $cart = $this->cartService->getOrCreateCart($data);


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
    public function delete(CartRequest $request)
    {
        $cart = $this->cartService->findCart($request->validated());
        if(!$cart) {
            return $this->error([],'Esse usuário não possui carrinho ativo.');
        }
        $cart->delete();

        return $this->success([], 'Carrinho removido com sucesso.');
    }
}
