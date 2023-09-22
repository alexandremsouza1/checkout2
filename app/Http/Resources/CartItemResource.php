<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CartItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $productResource = config('checkout.product_resource');

        return [
            'cartItemToken' => $this->token,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'customerNote' => $this->customer_note,
            'product' => new $productResource($this->whenLoaded('product'))
        ];
    }
}
