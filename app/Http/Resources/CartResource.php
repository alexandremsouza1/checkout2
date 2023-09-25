<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    const PAYMENT_METHODS = [
        'A' => 'bankSlip',
        'N' => 'pix',
        'X' => 'credit',
        'Y' => 'debit',
        'I' => 'financing',
        'Z' => 'non_authenticated_debit'
      ];

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $groupPaymentMethods = $this->groupPaymentConditions($this->whenLoaded('paymentMethods'));
        return [
            'cartToken' => $this->token,
            'subtotal' => $this->items_subtotal ?? null,
            'taxRate' => $this->tax_rate ? displayTaxRate($this->tax_rate) : null,
            'tax' => $this->tax ? displayMoney($this->tax) : null,
            //'total' => $this->total ? displayMoney($this->total) : null,
            'total' => $this->total,
            'discount' => $this->discount ? displayMoney($this->discount) : null,
            'shipping' => $this->shipping ? displayMoney($this->shipping) : null,
            'cartItems' => CartItemResource::collection($this->whenLoaded('cartItems')),
            'order' => new OrderResource($this->whenLoaded('order')),
            'paymentMethods' => $groupPaymentMethods
            //'deliveries' => new DeliveryResource($this->whenLoaded('deliveries')),
        ];
    }

    private function groupPaymentConditions($conditions)
    {
      $resources = [];
      foreach ($conditions as $condition) {
        $condicaoPagamento = isset(self::PAYMENT_METHODS[$condition['payment_method']]) ? self::PAYMENT_METHODS[$condition['payment_method']] : 'other';
  
        if (!isset($resources[$condicaoPagamento])) {
          $resources[$condicaoPagamento] = [];
        }

        $resources[$condicaoPagamento][] = new PaymentConditionsItemResource($condition);
      }
  
      return $resources;
    }
}
