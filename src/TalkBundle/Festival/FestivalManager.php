<?php
/**
 * Created by PhpStorm.
 * User: nekrasov
 * Date: 09.05.16
 * Time: 20:06
 */

namespace TalkBundle\Festival;


use Symfony\Component\DependencyInjection\ContainerInterface;

class FestivalManager
{
    protected $text;
    protected $output;

    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getText()
    {
        return str_replace(['"', '\''], ['', ''], $this->text);
    }

    public function getOutput()
    {
        return $this->output;
    }

    public function setOutput($output)
    {
        $this->output = $output;
    }

    public function setText($text)
    {
        $this->text = $text;
    }

    public function generate()
    {
        $path = $this->container->getParameter('festival_mp3_path');

        $filename = md5(time() . uniqid()) . ".mp3";
        $this->setOutput($filename);

        $output = '/' . trim($path, '/') . '/' . $this->getOutput();

        $text = $this->getText();

        exec("echo '$text' | text2wave | ffmpeg -i - -ar 44100 -ac 2 -ab 192k -f mp3 {$output}", $outputArray, $return);

        return $return == 0;
    }
}