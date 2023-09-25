<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class Token
{
    public static function generate()
    {
        return Str::uuid();
    }
}
