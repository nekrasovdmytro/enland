<?php
/**
 * Created by PhpStorm.
 * User: nekrasov
 * Date: 07.05.16
 * Time: 23:58
 */

namespace TalkBundle\Espeak;


use Symfony\Component\DependencyInjection\ContainerInterface;

class EspeakTextFile
{
    protected $container;

    protected $text;
    protected $filePath;

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

    public function setFilePath($filePath)
    {
        $this->filePath = $filePath;
    }

    public function getFilePath()
    {
        return $this->filePath;
    }

    public function createFile()
    {
        $path = $this->container->getParameter('espeak_text_file_path');

        $filename = md5(time().uniqid()) . 'txt';
        $this->setFilePath('/' . trim($path, '/') . '/' . $filename);

        $result = file_put_contents($this->getFilePath(), $this->getText());

        return $result !== false;
    }

    public function removeFile()
    {
        if (empty($this->getFilepath())) {
            throw new \Exception("File was not generated!");
        }

        if (!file_exists($this->getFilepath())) {
            throw new \Exception("File not exists");
        }

        return unlink($this->getFilepath());
    }


}