<?php

namespace App\Helper;

class Helper
{
    public static function numberFormat($number)
    {
        return number_format($number, 0, ',', '.');
    }
}
