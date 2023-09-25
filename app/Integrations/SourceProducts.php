<?php

namespace App\Integrations;


class SourceProducts
{

  private $client;


  public function __construct()
  {
    $this->client = new Client(env('MICROSERVICE_PRODUCTS_INTEGRATION_URL'));
  }

  public function getProducts($clientId,$sku)
  {
    $url = 'products?filters=products&clientId=' . $clientId . '&sku=' . $sku;
    $result = $this->client->get($url);
    return isset($result['data']) ? $result['data'] : [];
  }
}