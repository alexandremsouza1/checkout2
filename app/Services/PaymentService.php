<?php

namespace App\Services;

use App\Integrations\SourceSap;
use App\Models\Cart;
use App\Repositories\PaymentRepository;

class PaymentService extends AbstractService
{

  const PAYMENT_METHODS = [
    'A' => 'bankSlip',
    'N' => 'pix',
    'X' => 'credit',
    'Y' => 'debit',
    'I' => 'financing',
    'Z' => 'non_authenticated_debit'
  ];

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
    $groupConditions = $conditions ? $this->groupPaymentConditions($conditions) : [];
    foreach ($groupConditions as $key => $conditions) {
      if(is_array($conditions)){
        foreach ($conditions as $condition) {
          if(is_array($condition)){
            $hash = md5($cart->hash.$key.$condition['description']);
            $total = $cart->total*$condition['fee'];
            $this->paymentRepository->store([
              'hash' => $hash,
              'cart_id' => $cart->id,
              'name' => $key,
              'client_id' => $clientId,
              'description' => $condition['description'],
              'paymentMethod_description' => $condition['paymentMethodDescription'],
              'payment_condition' => $condition['paymentCondition'],
              'fee' => $condition['fee'],
              'payment_method' => $condition['paymentMethod'],
              'message' => $condition['message'],
              'block_reason' => $condition['blockReason'],
              'number' => $condition['number'],
              'default' => $condition['default'],
              'days' => $condition['days'],
              'installments' => $condition['installments'],
              'type' => $condition['type'],
              'total' => $total,
            ], 'hash');
          }
        }
      }
    }
  }


  private function groupPaymentConditions(array $conditions)
  {
    $groupedConditions = [];

    foreach ($conditions as $condition) {
      $condicaoPagamento = isset(self::PAYMENT_METHODS[$condition['FormaPagamento']]) ? self::PAYMENT_METHODS[$condition['FormaPagamento']] : 'other';

      if (!isset($groupedConditions[$condicaoPagamento])) {
        $groupedConditions[$condicaoPagamento] = [];
      }

      $groupedConditions[$condicaoPagamento][] = [
        'blocked' => $condition['Bloqueada'],
        'billingApp' => $condition['CobrancaAPP'],
        'code' => $condition['Codigo'],
        'description' => $condition['DescCondicao'],
        'paymentMethodDescription' => $condition['DescFormaPagamento'],
        'paymentCondition' => $condition['CondicaoPagamento'],
        'fee' => $condition['Encargo'],
        'paymentMethod' => $condition['FormaPagamento'],
        'message' => $condition['Message'],
        'blockReason' => $condition['MotivoBloqueio'],
        'number' => $condition['Number'],
        'default' => $condition['Padrao'],
        'days' => $condition['QtdDias'],
        'installments' => $condition['QtdeParcelas'],
        'type' => $condition['Type'],
      ];
    }

    return $groupedConditions;
  }
 
}