<?php

namespace App\Repositories;

use App\Models\Cart;
use Illuminate\Support\Arr;

class CartRepository extends AbstractRepository
{
    public function __construct(Cart $model)
    {
        $this->model = $model;
    }

    /***************************************************************************************
     ** CRUD
     ***************************************************************************************/

    public function makeOne(array $data)
    {
        $customerForeignKey = 'client_id';

        $cart = $this->model->where($customerForeignKey, $data[$customerForeignKey])->first();

        if (is_null($cart)) {
            $cart = new $this->model;
        }

        $cart->{$customerForeignKey} = isset($data[$customerForeignKey]) ? $data[$customerForeignKey] : null;
        $cart->customer_email = isset($data['customer_email']) ? $data['customer_email'] : null;
        $cart->items_subtotal = isset($data['items_subtotal']) ? $data['items_subtotal'] : 0;
        $cart->total = isset($data['total']) ? $data['total'] : 0;
        $cart->discount = isset($data['discount']) ? $data['discount'] : 0;
        $cart->ip_address = $data['ip_address'];
        $cart->save();
        if(!empty($data['items'])) {
            foreach ($data['items'] as $item) {
                \App\Facades\CartItem::getClassName()::makeOne($cart, $item);
            }
        }

        return $cart;
    }
}
