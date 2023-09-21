<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
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
            'cartToken' => $this->token,
            'itemsSubtotal' => displayMoney($this->items_subtotal),
            'taxRate' => displayTaxRate($this->tax_rate),
            'tax' => displayMoney($this->tax),
            'total' => displayMoney($this->total),
            'totalCents' => $this->total,
            'discount' => displayMoney($this->discount),
            'shipping' => displayMoney($this->shipping),
            'customerEmail' => $this->customer_email,
            'shippingFirstName' => $this->shipping_first_name,
            'shippingLastName' => $this->shipping_last_name,
            'shippingAddressLine1' => $this->shipping_address_line1,
            'shippingAddressLine2' => $this->shipping_address_line2,
            'shippingAddressCity' => $this->shipping_address_city,
            'shippingAddressRegion' => $this->shipping_address_region,
            'shippingAddressZipcode' => $this->shipping_address_zipcode,
            'shippingAddressPhone' => $this->shipping_address_phone,
            'billingSame' => (bool) $this->billing_same,
            'billingFirstName' => $this->billing_first_name,
            'billingLastName' => $this->billing_last_name,
            'billingAddressLine1' => $this->billing_address_line1,
            'billingAddressLine2' => $this->billing_address_line2,
            'billingAddressCity' => $this->billing_address_city,
            'billingAddressRegion' => $this->billing_address_region,
            'billingAddressZipcode' => $this->billing_address_zipcode,
            'billingAddressPhone' => $this->billing_address_phone,
            'customer' => new CustomerResource($this->whenLoaded('customer')),
            'cartItems' => CartItemResource::collection($this->whenLoaded('cartItems')),
            'order' => new OrderResource($this->whenLoaded('order'))
        ];
    }
}
