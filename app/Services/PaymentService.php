<?php

namespace App\Services;

use App\Enums\PaymentMethods;
use App\Integrations\SourceSap;
use App\Models\Cart;
use App\Repositories\PaymentRepository;

class PaymentService extends AbstractService
{

  const PAYMENT_METHODS = [
    'A' => 'bankSlip',
    'N' => 'pix',
    'X' => 'credit',
    'Y' => 'debit'
    // 'I' => 'financing',
    // 'Z' => 'non_authenticated_debit'
  ];

  private $paymentRepository;

  private $sourceSap;
  
  public function __construct(SourceSap $sourceSap, PaymentRepository $paymentRepository)
  {
    $this->paymentRepository = $paymentRepository;
    $this->sourceSap = $sourceSap;
  }


  public function create(Cart $cart)
  {
    $clientId = $cart->client_id;
    $conditions = $this->sourceSap->getConditions($clientId);
    if(!$conditions){
      return;
    }
    foreach ($conditions as $key => $condition) {
      if(is_array($condition)){
        if(!isset(self::PAYMENT_METHODS[$condition['FormaPagamento']])){
          continue;
        }
        $hash = md5($cart->id.$key.$condition['CondicaoPagamento']);
        $this->paymentRepository->store([
          'hash' => $hash,
          'cart_id' => $cart->id,
          'name' => $key,
          'billing_app' => $condition['CobrancaAPP'],
          'code' => $condition['Codigo'],
          'client_id' => $clientId,
          'description' => $condition['DescCondicao'],
          'payment_method_description' => $condition['DescFormaPagamento'],
          'payment_condition' => $condition['CondicaoPagamento'],
          'fee' => $condition['Encargo'],
          'payment_method' => self::PAYMENT_METHODS[$condition['FormaPagamento']],
          'message' => $condition['Message'],
          'block_reason' => $condition['MotivoBloqueio'],
          'number' => $condition['Number'],
          'default' => $condition['Padrao'],
          'days' => $condition['QtdDias'],
          'installments' => $condition['QtdeParcelas'],
          'type' => $condition['Type']
        ], 'hash');
      }
    }
  }


}