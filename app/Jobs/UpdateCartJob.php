<?php

namespace App\Jobs;

use App\Helpers\Price;
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
        $paymentSelected = $this->getSelectedPaymentMethods($this->cart);

        $items = $this->cart->cartItems()->get();
        foreach ($items as $item){
            $new_price = $item->product->price * $item->quantity;
            $item->price = Price::setValueWithFee($new_price, $paymentSelected->fee);
            $item->save();
        }
 
        $this->cart->fresh();
    }

    private function getSelectedPaymentMethods($cart)
    {
        $default = null;
        $active = null;
        $payments = $cart->paymentMethods()->get();
        foreach ($payments as $payment){
            $payment->total_amount = $this->cart->total;
            $value_per_installment = $payment->installments ? $this->cart->total / $payment->installments : $this->cart->total;
            $payment->partial_amount = Price::setValueWithFee($value_per_installment, $payment->fee);
            if($payment->active) {
                $active = $payment;
            }
            if($payment->default) {
                $default = $payment;
            }
            $payment->save();
        }

        if($active){
            return $active;
        }
        if($default){
            return $default;
        }
        $selected = $payments->first();
        $selected->active = true;
        return $selected->save();
    }

}
