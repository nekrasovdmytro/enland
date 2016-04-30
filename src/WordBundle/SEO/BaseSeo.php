<?php
/**
 * Created by PhpStorm.
 * User: nekrasov
 * Date: 07.01.16
 * Time: 18:42
 */

namespace WordBundle\SEO;


class BaseSeo
{
    protected $title;
    protected $description;
    protected $keywords;

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function setKeywords($keywords)
    {
        $keywords = is_array($keywords) ? implode(',', $keywords) : $keywords;
        $this->keywords = $keywords;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getKeywords()
    {
        return $this->keywords;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getAllMeta()
    {
        return [
            'title' => $this->getTitle(),
            'keywords' => $this->getKeywords(),
            'description' => $this->getDescription()
        ];
    }
}