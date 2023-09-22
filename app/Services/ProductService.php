<?php

namespace App\Services;

use App\Adapters\ProductsAdapter;
use App\Integrations\SourceProducts;
use App\Repositories\ProductRepository;

class ProductService extends AbstractService
{

  private $productRepository;

  private $productsAdapter;
  
  public function __construct(ProductRepository $productRepository, ProductsAdapter $productsAdapter)
  {
    $this->productRepository = $productRepository;
    $this->productsAdapter = $productsAdapter;
  }
 

  public function getOrCreateProduct($clientId,$data)
  {
    //$product = $this->productsAdapter->setProducts($clientId, $data)->adaptProducts();
    return $this->productRepository->store($data, 'code');
  }

  public function findProductByCode($code)
  {
    return $this->productRepository->findByKey('code', $code);
  }

}