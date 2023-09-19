<?php

namespace App\Services;

use App\Repositories\ProductRepository;

class ProductService extends AbstractService
{

  private $productRepository;
  
  public function __construct(ProductRepository $productRepository)
  {
    $this->productRepository = $productRepository;
  }
 

  public function getOrCreateProduct($data)
  {
    return $this->productRepository->store($data, 'code');
  }

}