<?php
namespace App\Helpers;

class Responder
{
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
            'error' => $error,
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
            'error' => $error,
        ];
    }
}
