<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentConditionsItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
          'blocked' => $this->blocked,
          'billingApp' => $this->billingApp,
          'code' => $this->code,
          'description' => $this->description,
          'paymentMethodDescription' => $this->payment_method_description,
          'paymentCondition' => $this->payment_condition,
          'fee' => $this->fee,
          'paymentMethod' => $this->payment_method,
          'message' => $this->message,
          'blockReason' => $this->blockReason,
          'number' => $this->number,
          'default' => $this->default,
          'days' => $this->days,
          'installments' => $this->installments,
          'type' => $this->type,
          'partialAmount' => $this->partial_amount,
          'totalAmount' => $this->total_amount,
        ];
    }
}
