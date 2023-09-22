<?php


namespace App\Adapters;

use App\Integrations\SourceProducts;

class ProductsAdapter implements ProductsAdapterInterface
{

  private $sourceProducts;

  private $products;

  public function __construct(SourceProducts $sourceProducts)
  {
    $this->sourceProducts = $sourceProducts;
  }


  public function setProducts($clientId, $data)
  {
    try {
      $result = $this->sourceProducts->getProducts($clientId, $data['code']);
      $this->products = $result['products'][0];
    } catch (\Exception $e) {
      $this->products = $data;
    }
    return $this;
  }

  public function adaptProducts()
  {
    $products = [];
    if(!$this->products) {
      return $products;
    }
    $products[] = [
      'code' => $this->products['sku'],
      'name' => $this->products['title'],
      'price' => $this->products['price'],
      'quantity' => $this->products['quantity'],
      'type' => $this->products['type'],
    ];
    return $products;
  }


}