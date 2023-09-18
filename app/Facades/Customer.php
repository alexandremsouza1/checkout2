<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Customer extends Facade
{
    public static function getFacadeAccessor()
    {
        return \App\Contracts\Customer::class;
    }
}
