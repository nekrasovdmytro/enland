<?php
/**
 * Created by PhpStorm.
 * User: nekrasov
 * Date: 24.12.15
 * Time: 14:29
 */

namespace WordBundle\Dictionary;


class EnglishDictionary extends AbstractDictionary
{
    const LANG = 'ru-en';
    const MAX_WORDS = 15000;

    public function getAlphabet()
    {
        return range('A', 'Z');
    }
}