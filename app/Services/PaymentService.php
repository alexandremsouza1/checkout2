<?php

namespace App\Services;

use App\Integrations\SourceSap;
use App\Models\Cart;
use App\Repositories\PaymentRepository;

class PaymentService extends AbstractService
{


  private $paymentRepository;

  private $sourceSap;
  
  public function __construct(SourceSap $sourceSap, PaymentRepository $paymentRepository)
  {
    $this->paymentRepository = $paymentRepository;
    $this->sourceSap = $sourceSap;
  }


  public function create(string $clientId, Cart $cart)
  {
    $conditions = $this->sourceSap->getConditions($clientId);
    if(!$conditions){
      return;
    }
    foreach ($conditions as $key => $condition) {
      if(is_array($condition)){
        $hash = md5($cart->id.$key.$condition['CondicaoPagamento']);
        $total = $cart->total;
        $partialTotal = $condition['QtdeParcelas'] ? ($total / $condition['QtdeParcelas']) : $total;
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
          'payment_method' => $condition['FormaPagamento'],
          'message' => $condition['Message'],
          'block_reason' => $condition['MotivoBloqueio'],
          'number' => $condition['Number'],
          'default' => $condition['Padrao'],
          'days' => $condition['QtdDias'],
          'installments' => $condition['QtdeParcelas'],
          'type' => $condition['Type'],
          'partial_amount' => $partialTotal,
          'total_amount' => $total,
        ], 'hash');
      }
    }
  }

 
}