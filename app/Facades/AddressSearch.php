<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class AddressSearch extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \App\Helpers\Address\AddressSearch::class;
    }
}
