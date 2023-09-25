<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentMethodResource extends JsonResource
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
            'name' => $this->name,
            'description' => $this->description,
            'paymentMethodDescription' => $this->paymentMethod_description,
            'payment_condition' => $this->payment_condition,
            'fee' => $this->fee,
            'payment_method' => $this->payment_method,
            'message' => $this->message,
            'block_reason' => $this->block_reason,
            'number' => $this->number,
            'default' => $this->default,
            'days' => $this->days,
            'installments' => $this->installments,
            'type' => $this->type,
            'total' => $this->total,
        ];
    }
}
