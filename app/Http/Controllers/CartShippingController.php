<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartZipCodeRequest;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use App\Services\CartService;

class CartShippingController extends Controller
{


    private $cartService;


    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }


    public function update(CartZipCodeRequest $request)
    {
        $data = $request->validated();
        $cart = $this->cartService->findCart($data);
        if(!$cart) {
            return $this->error([],'Esse usuário não possui carrinho ativo.');
        }

        $cart->updateShipping($data);

        return $this->success(new CartResource($cart->load('cartItems.product')));
    }
}
