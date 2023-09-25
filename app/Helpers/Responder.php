<?php
namespace App\Helpers;

/**
 * @OA\Schema(
 *     schema="SuccessResponse",
 *     type="object",
 *     @OA\Property(property="data", type="object", 
 *         example={
 *             "cartToken": "22bc82df-5750-4116-af17-e258e1d7030c",
 *             "itemsSubtotal": "5.00",
 *             "taxRate": null,
 *             "tax": null,
 *             "total": "5.30",
 *             "totalCents": 530,
 *             "discount": null,
 *             "shipping": "0.30",
 *             "cartItems": {
 *                 {
 *                     "cartItemToken": "6ae80be6-ef83-402b-b7b8-6cc441f66f14",
 *                     "price": "4.00",
 *                     "quantity": 4,
 *                     "customerNote": null,
 *                     "product": {
 *                         "name": "item1",
 *                         "image": null,
 *                         "price": "1.00"
 *                     }
 *                 },
 *                 {
 *                     "cartItemToken": "afac7afa-17fa-484c-bd2e-848ca9c3147d",
 *                     "price": "1.00",
 *                     "quantity": 1,
 *                     "customerNote": null,
 *                     "product": {
 *                         "name": "item1",
 *                         "image": null,
 *                         "price": "1.00"
 *                     }
 *                 }
 *             }
 *         }
 *     ),
 *     @OA\Property(property="status", type="boolean", example=true),
 *     @OA\Property(property="message", type="string", example="Success message")
 * )
 */
class Responder
{
    
    /**
     * @OA\Response(
     *     response=200,
     *     description="Success response",
     *     @OA\JsonContent(ref="#/components/schemas/SuccessResponse")
     * )
     *
     * @param array $data
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public static function success($data = [], string $message = '')
    {
        return response()->json([
            'data' => $data,
            'status' => true,
            'message' => $message,
        ]);
    }

    public static function error($data = [], string $error = '', $responseCode = 400)
    {
        return response()->json([
            'data' => $data,
            'status' => false,
            'message' => $error,
        ], $responseCode);
    }

    public static function noJsonSuccess($data = [], string $message = '')
    {
        return [
            'data' => $data,
            'status' => true,
            'message' => $message,
        ];
    }

    public static function noJsonError($data = [], string $error = '')
    {
        return [
            'data' => $data,
            'status' => false,
            'message' => $error,
        ];
    }
}
