<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class Helper
{

    public static function uniqStr($length = 5)
    {
        return  time() . Str::random($length);
    }
}
