<?php

namespace App\Repositories;

use App\Models\Customer;

class CustomerRepository extends AbstractRepository
{
    public function __construct(Customer $model)
    {
        $this->model = $model;
    }
}
