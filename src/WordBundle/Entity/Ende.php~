<?php

namespace WordBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ende
 *
 * @ORM\Table(name="ende", uniqueConstraints={@ORM\UniqueConstraint(name="enword", columns={"enword"})})
 * @ORM\Entity
 */
class Ende
{
    /**
     * @var string
     *
     * @ORM\Column(name="enword", type="string", length=255, nullable=false)
     */
    private $enword;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text", length=16777215, nullable=false)
     */
    private $content;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set enword
     *
     * @param string $enword
     *
     * @return Ende
     */
    public function setEnword($enword)
    {
        $this->enword = $enword;

        return $this;
    }

    /**
     * Get enword
     *
     * @return string
     */
    public function getEnword()
    {
        return $this->enword;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Ende
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
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
