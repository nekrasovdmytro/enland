<?php
/**
 * Created by PhpStorm.
 * User: nekrasov
 * Date: 04.01.16
 * Time: 16:25
 */

namespace WordBundle\Dictionary;


class DictionaryTools
{
    public static function translitUrl($str)
    {
        $str = str_replace('  ', '', trim($str));
        $str = strtolower($str);

        $str = preg_replace("/[^a-z\s]/", '', $str);

        $str = preg_replace("/[\s]/", '-', $str);

        return $str;
    }
}
