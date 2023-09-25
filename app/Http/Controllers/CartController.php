<?php

namespace App\Http\Controllers;

use App\Facades\Customer;
use App\Facades\Product;
use App\Http\Requests\CartRequest;
use App\Http\Resources\CartResource;
use App\Jobs\CreateCartJob;
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
    /**
     * @OA\Get(
     *     path="/api/carts",
     *     summary="Get cart",
     *     tags={"Cart"},
     *     @OA\Parameter(
     *         name="clientId",
     *         in="query",
     *         required=true,
     *         description="Client ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent( ref="#/components/schemas/SuccessResponse")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid parameters",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Invalid parameters"),
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
    /**
     * @OA\Post(
     *     path="/api/carts",
     *     summary="Create cart",
     *     tags={"Cart"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="clientId", type="string", example="0060033994"),
     *             @OA\Property(
     *                 property="items",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="code", type="integer", example=10254),
     *                     @OA\Property(property="weight", type="integer", example=100),
     *                     @OA\Property(property="name", type="string", example="item1"),
     *                     @OA\Property(property="price", type="integer", example=100),
     *                     @OA\Property(property="quantity", type="integer", example=2),
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Cart created successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Cart created successfully"),
     *             @OA\Property(property="data", type="object", example={"cartId": 1}),
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
     * )
     */
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
        CreateCartJob::dispatch($cart->client_id);

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
    /**
     * @OA\Delete(
     *     path="/api/carts",
     *     summary="Delete cart",
     *     tags={"Cart"},
     *     @OA\Parameter(
     *         name="clientId",
     *         in="query",
     *         required=true,
     *         description="Client ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Cart deleted successfully",
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
