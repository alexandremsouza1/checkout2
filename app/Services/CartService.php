<?php

namespace App\Services;

use App\Models\Cart;
use App\Repositories\CartRepository;
use App\Trait\StringTrait;

class CartService extends AbstractService
{

  use StringTrait;

  private $cartRepository;
  
  public function __construct(CartRepository $cartRepository)
  {
    $this->cartRepository = $cartRepository;
  }
 

  public function getOrCreateCart($data)
  {
    $data = $this->convertToSnakeCase($data);
    $cart = $this->cartRepository->makeOne($data);
    return $cart;
  }
  
  public function findCart($data) : Cart | bool
  {
    $cart = $this->cartRepository->findByKey('client_id', $data['clientId']);
    return $cart;
  }

}