<?php

namespace App\Contracts;

interface PaymentHandler
{
    public function purchase(array $order, array $paymentDetails, Customer $customer);
}
