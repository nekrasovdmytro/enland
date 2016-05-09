<?php
/**
 * Created by PhpStorm.
 * User: nekrasov
 * Date: 07.05.16
 * Time: 17:25
 */

namespace TalkBundle\Espeak;


class EspeakManager
{
    protected $espeakTextFile;
    protected $eSpeakMp3;
    protected $text;

    public function __construct(EspeakTextFile $espeakTextFile, EspeakMp3 $eSpeakMp3)
    {
        $this->espeakTextFile = $espeakTextFile;
        $this->eSpeakMp3 = $eSpeakMp3;
    }

    public function setText($text)
    {
        $this->text = $text;
    }

    public function getText()
    {
        return $this->text;
    }

    /**
     * @return \TalkBundle\Espeak\EspeakMp3
    */
    public function getESpeakMp3()
    {
        return $this->eSpeakMp3;
    }

    public function generateMp3()
    {
        //generate tmp file with text
        $this->espeakTextFile->setText($this->getText());
        $this->espeakTextFile->createFile();

        $filePath = $this->espeakTextFile->getFilepath();

        //get mp3 filePath
        $this->eSpeakMp3->setText($this->getText());
        $filePathMp3 = $this->eSpeakMp3->getFilePath();

        //execute mp3 by this file with text
        exec("espeak -f {$filePath} --stdout | ffmpeg -i - -ar 44100 -ac 2 -ab 192k -f mp3 {$filePathMp3}", $output, $return);

        //remove tmp text file
        $this->espeakTextFile->removeFile();

        return $return == 0;
    }
}
