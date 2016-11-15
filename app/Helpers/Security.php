<?php

namespace App\Helpers;

class Security
{
    public static function slowCompare($a, $b)
    {
         $diff = strlen($a) ^ strlen($b);
         for($i = 0; $i < strlen($a) && $i < strlen($b); $i++)
         {
             $diff |= ord($a[$i]) ^ ord($b[$i]);
         }
         return $diff === 0;
    }

    public static function generateToken()
    {
        $str = '23456789ABCDEFGHJKLMNPQRSTUVWXYZ';
        $arr = str_split($str);

        shuffle($arr);

        return substr(implode($arr), 0, 5);
    }
}
