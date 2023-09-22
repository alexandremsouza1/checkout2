<?php

namespace App\Adapters;


interface ProductsAdapterInterface
{
  public function adaptProducts();

  public function setProducts($clientId, $data);

}