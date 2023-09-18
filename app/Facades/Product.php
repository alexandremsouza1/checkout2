<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Product extends Facade
{
    public static function getFacadeAccessor()
    {
        return \App\Contracts\Product::class;
    }
}
