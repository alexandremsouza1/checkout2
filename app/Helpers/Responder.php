<?php
namespace App\Helpers;

/**
 * @OA\Schema(
 *     schema="SuccessResponse",
 *     type="object",
 *     @OA\Property(property="data", type="object", example={"key": "value"}),
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
