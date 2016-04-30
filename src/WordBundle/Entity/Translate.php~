<?php

namespace WordBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Translate
 *
 * @ORM\Table(name="translate")
 * @ORM\Entity
 */
class Translate
{
    /**
     * @var string
     *
     * @ORM\Column(name="words", type="string", length=500, nullable=false)
     */
    private $words;

    /**
     * @var string
     *
     * @ORM\Column(name="translate", type="text", length=65535, nullable=false)
     */
    private $translate;

    /**
     * @var string
     *
     * @ORM\Column(name="code_words", type="string", length=35, nullable=false)
     */
    private $codeWords;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set words
     *
     * @param string $words
     *
     * @return Translate
     */
    public function setWords($words)
    {
        $this->words = $words;

        return $this;
    }

    /**
     * Get words
     *
     * @return string
     */
    public function getWords()
    {
        return $this->words;
    }

    /**
     * Set translate
     *
     * @param string $translate
     *
     * @return Translate
     */
    public function setTranslate($translate)
    {
        $this->translate = $translate;

        return $this;
    }

    /**
     * Get translate
     *
     * @return string
     */
    public function getTranslate()
    {
        return $this->translate;
    }

    /**
     * Set codeWords
     *
     * @param string $codeWords
     *
     * @return Translate
     */
    public function setCodeWords($codeWords)
    {
        $this->codeWords = $codeWords;

        return $this;
    }

    /**
     * Get codeWords
     *
     * @return string
     */
    public function getCodeWords()
    {
        return $this->codeWords;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'trans' => $this->getTranslate(),
            'text' => $this->getWords()
        ];
    }
}
