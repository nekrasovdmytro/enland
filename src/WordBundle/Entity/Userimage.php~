<?php

namespace WordBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Userimage
 *
 * @ORM\Table(name="userimage")
 * @ORM\Entity
 */
class Userimage
{
    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer", nullable=false)
     */
    private $userId = '2';

    /**
     * @var string
     *
     * @ORM\Column(name="userfile", type="string", length=255, nullable=false)
     */
    private $userfile;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=false)
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="stars", type="integer", nullable=false)
     */
    private $stars;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=false)
     */
    private $date = 'CURRENT_TIMESTAMP';

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
     * @return Userimage
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
     * Set userfile
     *
     * @param string $userfile
     *
     * @return Userimage
     */
    public function setUserfile($userfile)
    {
        $this->userfile = $userfile;

        return $this;
    }

    /**
     * Get userfile
     *
     * @return string
     */
    public function getUserfile()
    {
        return $this->userfile;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Userimage
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set stars
     *
     * @param integer $stars
     *
     * @return Userimage
     */
    public function setStars($stars)
    {
        $this->stars = $stars;

        return $this;
    }

    /**
     * Get stars
     *
     * @return integer
     */
    public function getStars()
    {
        return $this->stars;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Userimage
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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
