<?php

namespace App\Http\Controllers;

use App\CheckoutFields;
use App\Contracts\State;

class CheckoutSettingsController extends Controller
{
    public function index(State $state)
    {
        return $this->success([
            'required' => CheckoutFields::required(),
            'states' => $state->all(),
            'toc_url' => config('checkout.toc_url'),
            'currency_symbol' => config('checkout.currency.symbol')
        ]);
    }
}
