<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CartService;


class CartController extends DefaultApiController
{


  protected $service;


  public function __construct(CartService $service)
  {
      $this->service = $service;
  }

  public function index($user)
  {
    $cart = $this->service->getCart('default');
    $statusCode = 200;
    $messageText = 'Carrinho retornado com sucesso';
    return response()->json(['data' => $cart, 'message' => $messageText, 'status' => true], $statusCode);
  }

  public function add(Request $request, $user)
  {
    $data = $request->all();
    $cart = $this->service->addItem('default',$data);
    $statusCode = 200;
    $messageText = 'Item adicionado ao carrinho com sucesso';
    return response()->json(['data' => $cart, 'message' => $messageText, 'status' => true], $statusCode);
  }


  public function update(Request $request)
  {
    $params = $request->all();
    $cart = $this->service->updateCart($params);
    $statusCode = 200;
    $messageText = 'Carrinho atualizado com sucesso';
    return response()->json(['data' => $cart, 'message' => $messageText, 'status' => true], $statusCode);
  }

  public function updateItem(Request $request, $item, $attribute, $value)
  {
    $user = $request->input('user');
    $cart = $this->service->updateItem($user, $item, $attribute, $value);
    $statusCode = 200;
    $messageText = 'Item atualizado com sucesso';
    return response()->json(['data' => $cart, 'message' => $messageText, 'status' => true], $statusCode);
  }


  public function updateShipping(Request $request, $shipping)
  {
    $user = $request->input('user');
    $cart = $this->service->updateShipping($user, $shipping);
    $statusCode = 200;
    $messageText = 'Frete atualizado com sucesso';
    return response()->json(['data' => $cart, 'message' => $messageText, 'status' => true], $statusCode);
  }

  public function remove(Request $request, $item)
  {
    $user = $request->input('user');
    $cart = $this->service->removeItem($user, $item);
    $statusCode = 200;
    $messageText = 'Item removido com sucesso';
    return response()->json(['data' => $cart, 'message' => $messageText, 'status' => true], $statusCode);
  }


}