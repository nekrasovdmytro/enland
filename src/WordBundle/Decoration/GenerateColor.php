<?php

/**
 * Created by PhpStorm.
 * User: nekrasov
 * Date: 25.12.15
 * Time: 21:26
 */

namespace WordBundle\Decoration;

class GenerateColor
{
    const DARK_TONE = 0;
    const LIGHT_TONE = 1;

    public static function generate($tone = self::DARK_TONE, $min = null, $max = null)
    {
        if ($min === null || $max === null) {
            $min = $tone == self::LIGHT_TONE ? 127 : 0;
            $max = $tone == self::LIGHT_TONE ? 255 : 127;
        }

        $r = mt_rand($min, $max);
        $g = mt_rand($min, $max);
        $b = mt_rand($min, $max);

        return [$r, $g, $b];
    }
}