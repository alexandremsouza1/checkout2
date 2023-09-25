<?php

namespace App\Jobs;

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

    private $clientId;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $clientId)
    {
        //$this->deliveryService = $deliveryService;
        //$this->paymentService = $paymentService;
        $this->clientId = $clientId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(PaymentService $paymentService,CartService $cartService)
    {
        $cart = $cartService->findCartByClientId($this->clientId);
        $payment = $paymentService->create($this->clientId,$cart);
        return $payment;
    }

}
