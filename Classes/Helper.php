<?php

namespace Classes;

use Illuminate\Support\Facades\Config;

class Helper
{
    public function enCrypte($value)
    {

        $lenValue = strlen($value);
        $right = strrev(substr($value, $lenValue - 2));
        $value = substr($value, 0, $lenValue - 2);
        $left = strrev(substr($value, 0, 2));
        $value = substr($value, 2);
        $base = strrev(base64_encode($value));
        $code = $right . $base . $left;
        return $code;

    }

    public function deCrypte($value)
    {
        $code = $value;
        $left = substr($code, -2);
        $left = strrev($left);
        $code = substr($code, 0, strlen($code) - 2);
        $right = substr($code, 0, 2);
        $right = strrev($right);
        $code = substr($code, 2);
        $base = base64_decode(strrev($code));
        $result = $left . $base . $right;
        return $result;

    }

    public function persian2LatinDigit($string)
    {
        $persian_digits = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
        $arabic_digits = array('٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩');
        $english_digits = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');

        $string = str_replace($persian_digits, $english_digits, $string);
        $string = str_replace($arabic_digits, $english_digits, $string);

        return $string;
    }

    static function menuActive($url, $section)
    {
        $array_url = [];
        foreach ($url as $item) {
            $array_url[] = Config::get('site.' . $section) . '/' . $item;
            $array_url[] = Config::get('site.' . $section) . '/' . $item . '/*';
        }
        return call_user_func_array('Request::is', (array)$array_url) ? 'active' : '';
    }

    static function curl($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    public static function seo($var, $lower = true, $punkt = true)
    {
        $var = str_replace(".php", "", $var);
        $var = trim(strip_tags($var));
        $var = preg_replace("/\s+/ms", "-", $var);
        if (strlen($var) > 70) {
            $var = substr($var, 0, 70);
            if (($temp_max = strrpos($var, '-'))) $var = substr($var, 0, $temp_max);
        }
        $search = array('+', '/', '@', '#', '"', '=', '\\', '.', '(', ')');
        $replace = array('');

        return str_replace($search, $replace, $var);
    }
}