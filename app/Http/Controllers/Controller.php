<?php

namespace App\Http\Controllers;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Checkout Microservice",
 *      description="Checkout Microservice API Documentation",
 *      @OA\Contact(
 *          email="administrativo@mobiup.com.br"
 *      ),
 *      @OA\License(
 *          name="MIT License",
 *          url=""
 *      )
 * )
 *
 * @OA\Server(
 *      url=L5_SWAGGER_CONST_HOST,
 *      description="API Server"
 * )
 *
 */

use App\Helpers\Responder;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Contracts\Validation\Validator;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function success($data = [], string $message = '')
    {
        return Responder::success($data, $message);
    }

    public function error($data = [], string $message = '', $responseCode = 400)
    {
        return Responder::error($data, $message, $responseCode);
    }

    protected function formatValidationErrors(Validator $validator)
    {
        // get all errors
        $errors = $validator->errors()->all();

        // get first error for message
        $collection = collect($errors);
        $first_error = $collection->first();
        return Responder::noJsonError($errors, $first_error);
    }
}
