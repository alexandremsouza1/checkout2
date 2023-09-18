<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class OrderItem extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \App\Contracts\OrderItem::class;
    }
}
