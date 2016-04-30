<?php
/**
 * Created by PhpStorm.
 * User: nekrasov
 * Date: 28.12.15
 * Time: 19:54
 */

namespace WordBundle\BibleSphinxSearch;


class BibleTranslator
{
    protected $link = 'https://www.bibleonline.ru/bible/rus/%s/%s/';

    protected function getContent($book, $location)
    {
        $book = intval($book);
        $location = intval($location);

        $preparedLink = sprintf($this->link, $book, $location);

        return file_get_contents($preparedLink);
    }

    protected function getVerse($number, $content)
    {
        $number = intval($number);
        $match = [];

        preg_match("@<li id=\"v{$number}\"[^>]+>(.+?)</li>@ims", $content, $match);

        return (isset($match[0])) ? strip_tags($match[0]) : '';
    }

    public function getTranslation($book, $location, $number)
    {
        $content = $this->getContent($book, $location);

        return $this->getVerse($number, $content);
    }
}