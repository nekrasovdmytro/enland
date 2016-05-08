<?php

namespace TalkBundle\Espeak;

use Symfony\Component\DependencyInjection\ContainerInterface;

class EspeakMp3
{
    protected $container;
    protected $text;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function setText($text)
    {
        $this->text = $text;
    }

    public function getText()
    {
        return $this->text;
    }

    public function getFilename()
    {
        if (empty($this->getText())) {
            throw new \Exception("Text is not set to generate mp3 filename");
        }

        return md5($this->getText()) . '.mp3';
    }

    public function getFilePath()
    {
        $path = $this->container->getParameter('espeak_mp3_path');

        return '/' . trim($path, '/') . '/' . $this->getFilename();
    }
}