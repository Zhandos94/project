<?php
/**
 * Created by BADI.
 * DateTime: 13.01.2017 18:14
 */

namespace frontend\helpers;


class NumericHelper
{

    public static function reformatting($value, $decimalCount = null)
    {
        if (preg_match('/\./', $value)) {
            if ($value{strlen($value) - 1} == '.') {
                $value = substr($value, 0, -1);
            } else {
                $parts = explode('.', $value);
                $intPart = $parts[0];
                $floatPart = $parts[1];
                if (!preg_match('/[1-9]/', $floatPart)) {
                    $value = $intPart;
                } else {
                    while ($floatPart{strlen($floatPart) - 1} == '0') {
                        $floatPart = substr($floatPart, 0, -1);
                    }
                    if($decimalCount !== null && is_int($decimalCount)){
                        $floatPart = substr($floatPart, 0, $decimalCount);
                    }
                    $value = $intPart . '.' . $floatPart;
                }
            }
        }
//        var_dump($value);
        return $value;
    }
}