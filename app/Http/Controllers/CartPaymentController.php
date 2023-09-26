<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartPaymentRequest;
use App\Http\Resources\CartResource;
use App\Jobs\UpdateCartJob;
use App\Models\Cart;
use App\Services\CartService;

class CartPaymentController extends Controller
{


    private $cartService;


    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

   
    public function update(CartPaymentRequest $request)
    {
        $data = $request->validated();
        $cart = $this->cartService->findCart($data);
        if(!$cart) {
            return $this->error([],'Esse usuário não possui carrinho ativo.');
        }

        $cart->paymentMethods()->update(['active' => false]);
        $cart->paymentMethods()->where('payment_condition', $data['paymentCondition'])->update(['active' => true]);

        UpdateCartJob::dispatch($cart);

        return $this->success(new CartResource($cart->fresh()->load(['cartItems.product', 'order','paymentMethods'])));
    }
}
