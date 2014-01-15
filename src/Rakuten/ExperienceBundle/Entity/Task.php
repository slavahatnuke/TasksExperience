<?php

namespace Rakuten\ExperienceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * Task
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Rakuten\ExperienceBundle\Entity\TaskRepository")
 *
 * @Serializer\ExclusionPolicy("all")
 */
class Task
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     *
     * @Serializer\Expose
     */
    private $title;

    /**
     * @var boolean
     *
     * @ORM\Column(name="isDone", type="boolean")
     *
     * @Serializer\Expose
     */
    private $isDone;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Task
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set isDone
     *
     * @param boolean $isDone
     * @return Task
     */
    public function setIsDone($isDone)
    {
        $this->isDone = $isDone;

        return $this;
    }

    /**
     * Get isDone
     *
     * @return boolean 
     */
    public function getIsDone()
    {
        return $this->isDone;
    }
}
