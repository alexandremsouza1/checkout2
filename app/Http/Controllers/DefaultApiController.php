<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Checkout Microservice",
 *      description="Register Microservice API Documentation",
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
abstract class DefaultApiController extends BaseController
{
    //
}

