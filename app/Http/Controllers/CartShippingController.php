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

    /**
     * @OA\Put(
     *     path="/api/carts/shipping",
     *     summary="Update cart shipping information",
     *     tags={"Cart Shipping"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="clientId", type="string", example="0060033994"),
     *             @OA\Property(
     *                 property="shipping",
     *                 type="object",
     *                 @OA\Property(property="price", type="integer", example=30),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Cart shipping information updated successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Cart shipping information updated successfully"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Bad Request"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Unauthorized"),
     *         ),
     *     ),
     * )
     */
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
