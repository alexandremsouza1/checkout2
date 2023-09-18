<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CheckoutService;


class CheckoutController extends DefaultApiController
{
    
  protected $service;


  public function __construct(CheckoutService $service)
  {
      $this->service = $service;
  }


  public function index(Request $request)
  {
    $user = $request->input('user');
    $checkout = $this->service->getCheckout($user);
    $statusCode = 200;
    $messageText = 'Checkout retornado com sucesso';
    return response()->json(['data' => $checkout, 'message' => $messageText, 'status' => true], $statusCode);
  }

  public function updatePaymentMethod(Request $request, $id, $condition)
  {
    $user = $request->input('user');
    $checkout = $this->service->updatePaymentMethod($user, $id, $condition);
    $statusCode = 200;
    $messageText = 'Método de pagamento atualizado com sucesso';
    return response()->json(['data' => $checkout, 'message' => $messageText, 'status' => true], $statusCode);
  }

  public function checkout(Request $request)
  {
    $user = $request->input('user');
    $checkout = $this->service->checkout($user);
    $statusCode = 200;
    $messageText = 'Pagamento realizado com sucesso';
    return response()->json(['data' => $checkout, 'message' => $messageText, 'status' => true], $statusCode);
  }
}