<?php

namespace App\Jobs;

use App\Models\Cart;
use App\Services\CartService;
use App\Services\PaymentService;
use Faker\Provider\ar_EG\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateCartJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $deliveryService;


    public $paymentService;

    private $cart;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Cart $cart)
    {
        $this->cart = $cart;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(PaymentService $paymentService)
    {
        if(!$this->cart->paymentMethods()->count()){
            $paymentService->create($this->cart);
        }
        $paymentDefault = $this->getPaymentMethodDefault($this->cart);

        $items = $this->cart->cartItems()->get();
        foreach ($items as $item){
            $new_price = $item->product->price * $item->quantity;
            $item->price = $new_price * (1 + ($paymentDefault->fee / 100));
            $item->save();
        }
 
        $paymentDefault->total_amount = $this->cart->total;
        $paymentDefault->partial_amount = $paymentDefault->installments ? ($this->cart->total / $paymentDefault->installments) : $this->cart->total;
        $paymentDefault->save();

        $this->cart->fresh();
    }

    private function getPaymentMethodDefault($cart)
    {
        $paymentDefault = $cart->paymentMethods()->where('default',true)->first();
        if(!$paymentDefault){
            $paymentDefault = $cart->paymentMethods()->first();
            $paymentDefault->default = true;
            $paymentDefault->save();
        }
        return $paymentDefault;
    }

}
