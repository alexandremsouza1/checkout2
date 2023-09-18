<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\OrderPurchase;

class NewOrderPurchase
{
    use Dispatchable, SerializesModels;

    /** @var OrderPurchase */
    public $order;

    /**
     * @param OrderPurchase $order
     */
    public function __construct(OrderPurchase $order)
    {
        $this->order = $order;
    }
}
