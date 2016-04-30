<?php

namespace WordBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Remember
 *
 * @ORM\Table(name="remember")
 * @ORM\Entity
 */
class Remember
{
    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer", nullable=false)
     */
    private $userId;

    /**
     * @var integer
     *
     * @ORM\Column(name="content_id", type="integer", nullable=false)
     */
    private $contentId;

    /**
     * @var string
     *
     * @ORM\Column(name="word", type="text", length=65535, nullable=false)
     */
    private $word;

    /**
     * @var string
     *
     * @ORM\Column(name="translate", type="text", length=65535, nullable=false)
     */
    private $translate;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="text", length=65535, nullable=false)
     */
    private $comment;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=false)
     */
    private $date = 'CURRENT_TIMESTAMP';

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_arch", type="boolean", nullable=false)
     */
    private $isArch;

    /**
     * @var string
     *
     * @ORM\Column(name="lang", type="string", length=2, nullable=false)
     */
    private $lang = 'ru';

    /**
     * @var string
     *
     * @ORM\Column(name="tlang", type="string", length=2, nullable=false)
     */
    private $tlang = 'en';

    /**
     * @var string
     *
     * @ORM\Column(name="images", type="text", length=65535, nullable=false)
     */
    private $images;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set userId
     *
     * @param integer $userId
     *
     * @return Remember
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return integer
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set contentId
     *
     * @param integer $contentId
     *
     * @return Remember
     */
    public function setContentId($contentId)
    {
        $this->contentId = $contentId;

        return $this;
    }

    /**
     * Get contentId
     *
     * @return integer
     */
    public function getContentId()
    {
        return $this->contentId;
    }

    /**
     * Set word
     *
     * @param string $word
     *
     * @return Remember
     */
    public function setWord($word)
    {
        $this->word = $word;

        return $this;
    }

    /**
     * Get word
     *
     * @return string
     */
    public function getWord()
    {
        return $this->word;
    }

    /**
     * Set translate
     *
     * @param string $translate
     *
     * @return Remember
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
     * Set comment
     *
     * @param string $comment
     *
     * @return Remember
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Remember
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set isArch
     *
     * @param boolean $isArch
     *
     * @return Remember
     */
    public function setIsArch($isArch)
    {
        $this->isArch = $isArch;

        return $this;
    }

    /**
     * Get isArch
     *
     * @return boolean
     */
    public function getIsArch()
    {
        return $this->isArch;
    }

    /**
     * Set lang
     *
     * @param string $lang
     *
     * @return Remember
     */
    public function setLang($lang)
    {
        $this->lang = $lang;

        return $this;
    }

    /**
     * Get lang
     *
     * @return string
     */
    public function getLang()
    {
        return $this->lang;
    }

    /**
     * Set tlang
     *
     * @param string $tlang
     *
     * @return Remember
     */
    public function setTlang($tlang)
    {
        $this->tlang = $tlang;

        return $this;
    }

    /**
     * Get tlang
     *
     * @return string
     */
    public function getTlang()
    {
        return $this->tlang;
    }

    /**
     * Set images
     *
     * @param string $images
     *
     * @return Remember
     */
    public function setImages($images)
    {
        $this->images = $images;

        return $this;
    }

    /**
     * Get images
     *
     * @return string
     */
    public function getImages()
    {
        return $this->images;
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
}
