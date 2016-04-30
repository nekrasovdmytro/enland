<?php
/**
 * Created by PhpStorm.
 * User: nekrasov
 * Date: 07.01.16
 * Time: 18:47
 */

namespace WordBundle\SEO;


class WordSeo extends BaseSeo
{
    protected $additionTitle = '';
    protected $separator = ' - ';

    public function setTitle($title)
    {
        parent::setTitle(ucfirst($title) . $this->getSeparator() . $this->getAdditionTitle());
    }

    public function setAdditionTitle($additionTitle)
    {
        $this->additionTitle = $additionTitle;
    }

    public function setSeparator($separator)
    {
        $this->separator = $separator;
    }

    public function getSeparator()
    {
        return $this->separator;
    }

    public function getAdditionTitle()
    {
        return $this->additionTitle;
    }
}