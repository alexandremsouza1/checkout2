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
        $this->onConnection($this->resolveQueueConnection());
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

 
        $totalProducts = $this->cart->total_products;
        $this->bootPaymentMethods($this->cart,$totalProducts);

        $paymentSelected = $this->cart->paymentMethods()->where('active', true)->first();
        if(!$paymentSelected) {
            $paymentSelected = $this->cart->paymentMethods()->first();
            $paymentSelected->active = true;
            $paymentSelected->save();
        }

        $items = $this->cart->cartItems()->get();
        foreach ($items as $item) {
            $new_price = $item->product->price * $item->quantity;
            $item->price = Price::setValueWithFee($new_price, $paymentSelected->fee);
            $item->save();
        }
    }

    private function bootPaymentMethods($cart,$totalProducts)
    {
        $payments = $cart->paymentMethods()->get();
        foreach ($payments as $payment) {
            $valuePerInstallment = $payment->installments ?  $totalProducts / $payment->installments : $totalProducts;
            $payment->partial_amount = Price::setValueWithFee($valuePerInstallment, $payment->fee);
            $payment->total_amount = Price::setValueWithFee($totalProducts, $payment->fee);
            $payment->save();
        }
    }

    protected function resolveQueueConnection()
    {
        return 'sync';
    }

}
