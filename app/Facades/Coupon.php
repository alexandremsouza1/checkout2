<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Coupon extends Facade
{
    public static function getFacadeAccessor()
    {
        return \App\Contracts\Coupon::class;
    }
}
