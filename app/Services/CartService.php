<?php

namespace App\Services;


use App\Repositories\CartRepository;


class CartService extends AbstractService
{

  private $cartRepository;
  
  public function __construct(CartRepository $cartRepository)
  {
    $this->cartRepository = $cartRepository;
  }
 

  public function getOrCreateCart($customer, $add_items, $request)
  {
    $cart =$this->cartRepository->makeOne([
      $customer->getForeignKey() => $customer->client_id,
      'customer_email' => $customer->email,
      'ip_address' => $request->ip(),
      'add_items' => $add_items
    ]);
    return $cart;
  } 

}