<?php
namespace App\Helpers;

use App\Models\CartItem;

class Price
{
    public static function getTax($subTotal, $taxRate)
    {
        return $subTotal * ($taxRate / 100 / 100);
    }

    public static function setValueWithFee($price, $fee)
    {
        return $price * (1 + ($fee / 100));
    }
}
