<?php

namespace App\Integrations;


class SourceSap
{

  private $client;


  public function __construct()
  {
    $this->client = new Client(env('MICROSERVICE_SAP_INTEGRATION_URL'));
  }

  public function getConditions($clientId)
  {
    $url = 'consultar-condicoes-pagamento?clientId=' . $clientId;
    $result = $this->client->get($url);
    return isset($result['data']) ? $result['data'] : [];
  }
}