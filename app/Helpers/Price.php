<?php
namespace App\Helpers;

class Price
{
    public static function getTax($subTotal, $taxRate)
    {
        return $subTotal * ($taxRate / 100 / 100);
    }
}
