<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository extends AbstractRepository
{
    public function __construct(Product $model)
    {
        $this->model = $model;
    }
}
