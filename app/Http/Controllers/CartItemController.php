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
    /**
     * @OA\Post(
     *     path="/api/carts/cart-items/{code}",
     *     summary="Create cart item",
     *     tags={"Cart Item"},
     *     @OA\Parameter(
     *         name="code",
     *         in="path",
     *         required=true,
     *         description="Item code",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="clientId", type="string", example="0060033994"),
     *             @OA\Property(
     *                 property="item",
     *                 type="object",
     *                 @OA\Property(property="code", type="integer", example=10255),
     *                 @OA\Property(property="weight", type="integer", example=100),
     *                 @OA\Property(property="name", type="string", example="item1"),
     *                 @OA\Property(property="price", type="integer", example=100),
     *                 @OA\Property(property="quantity", type="integer", example=2),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Cart item created successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Cart item created successfully"),
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
    /**
     * @OA\Put(
     *     path="/api/carts/cart-items/{code}",
     *     summary="Update cart item quantity",
     *     tags={"Cart Item"},
     *     @OA\Parameter(
     *         name="code",
     *         in="path",
     *         required=true,
     *         description="Item code",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="clientId", type="string", example="0060033994"),
     *             @OA\Property(
     *                 property="item",
     *                 type="object",
     *                 @OA\Property(property="quantity", type="integer", example=5),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Cart item quantity updated successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Cart item quantity updated successfully"),
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
    /**
     * @OA\Delete(
     *     path="/api/carts/cart-items/{code}",
     *     summary="Delete cart item",
     *     tags={"Cart Item"},
     *     @OA\Parameter(
     *         name="code",
     *         in="path",
     *         required=true,
     *         description="Item code",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="clientId", type="string", example="0060033994"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Cart item deleted successfully",
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
     *     security={
     *         {"bearerAuth": {}}
     *     }
     * )
     */
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
