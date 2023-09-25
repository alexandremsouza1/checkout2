<?php

namespace App\Repositories;

use App\Models\Payment;

class PaymentRepository extends AbstractRepository
{
    public function __construct(Payment $model)
    {
        $this->model = $model;
    }
}
