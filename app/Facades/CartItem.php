<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class CartItem extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \App\Contracts\CartItem::class;
    }
}
