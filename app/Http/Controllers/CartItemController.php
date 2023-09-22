<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartItemRequest;
use App\Http\Resources\CartItemResource;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use App\Models\CartItem;
use App\Services\CartService;
use App\Services\ProductService;
use Illuminate\Http\Request;

class CartItemController extends Controller
{

    
    private $productService;

    private $cartService;


    public function __construct(ProductService $productService, CartService $cartService)
    {
        $this->productService = $productService;
        $this->cartService = $cartService;
    }
    /***************************************************************************************
     ** POST
     ***************************************************************************************/
    public function create(CartItemRequest $request)
    {
        $data = $request->validated();
        $cart = $this->cartService->findCart($data);
        if(!$cart) {
            return $this->error([],'Esse usuário não possui carrinho ativo.');
        }
        $product = $this->productService->getOrCreateProduct($data['clientId'],$data['item']);
        $data['product_id'] = $product->id;
        CartItem::makeOne($cart, $data);

        $cart = $cart->fresh();
        $cart->load('cartItems.product');

        return $this->success(new CartResource($cart));
    }

    /***************************************************************************************
     ** PUT
     ***************************************************************************************/
    public function update($cartItemCode, CartItemRequest $request)
    {
        $data = $request->validated();
        $cart = $this->cartService->findCart($data);
        if(!$cart) {
            return $this->error([],'Esse usuário não possui carrinho ativo.');
        }
        $product = $this->productService->findProductByCode($cartItemCode);
        if(!$product) {
            return $this->error([],'Produto não encontrado.');
        }
        $cartItem = $cart->cartItems()->where('product_id', $product->id)->firstOrFail();
        $cartItem->updateMe(['quantity' => $data['item']['quantity']]);
        $cart = $cartItem->cart;
        $cart->load('cartItems.product');

        return $this->success(new CartResource($cart));
    }

    /***************************************************************************************
     ** DELETE
     ***************************************************************************************/
    public function delete($cartItemCode, CartItemRequest $request)
    {
        $data = $request->validated();
        $cart = $this->cartService->findCart($data);
        if(!$cart) {
            return $this->error([],'Esse usuário não possui carrinho ativo.');
        }
        $product = $this->productService->findProductByCode($cartItemCode);
        if(!$product) {
            return $this->error([],'Produto não encontrado.');
        }
        $cartItem = $cart->cartItems()->where('product_id', $product->id)->firstOrFail();
        $cartItem->delete();

        return $this->success();
    }
}
