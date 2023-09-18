<?php

namespace App\Contracts;

interface State
{
    public function all();

    public function getByCode($stateCode);
}
