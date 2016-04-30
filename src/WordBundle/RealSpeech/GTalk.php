<?php

/**
 * Created by PhpStorm.
 * User: nekrasov
 * Date: 26.12.15
 * Time: 8:58
 */
namespace WordBundle\RealSpeech;

class GTalk
{
    protected $text;

    public function getSpeech($text = null)
    {
        !is_null($text) && $this->setText($text);

        $ch = curl_init();

        $url_with_params = "http://speech.jtalkplugin.com/api/?speech=" . $this->getText() . "&usecache=false&format=mp3";

        curl_setopt($ch, CURLOPT_URL, $url_with_params);
        curl_setopt($ch, CURLOPT_HEADER, false);

        $json_result = trim(curl_exec($ch));

        $php_result = json_decode($json_result,true);

        curl_close($ch);

        return $php_result;
    }

    public function setText($text)
    {
        $this->text = $text;
    }

    public function getText()
    {
        return $this->text;
    }
}