<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Shipping extends Facade
{
    public static function getFacadeAccessor()
    {
        return \App\Contracts\Shipping::class;
    }
}
