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

    /**
     * @OA\Put(
     *     path="/carts/payment",
     *     summary="Atualiza o pagamento do carrinho",
     *     tags={"Carrinho"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="clientId", type="string", example="0068000249"),
     *             @OA\Property(property="paymentCondition", type="string", example="XX03"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Pagamento atualizado com sucesso",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Erro na solicitação",
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Não autorizado",
     *     ),
     * )
     */
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
