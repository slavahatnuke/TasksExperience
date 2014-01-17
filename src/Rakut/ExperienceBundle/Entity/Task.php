<?php

namespace Rakut\ExperienceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * Task
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Rakut\ExperienceBundle\Entity\TaskRepository")
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
     *
     * @Serializer\Expose
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
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
     * @var \Rakut\ExperienceBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="tasks")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

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

    /**
     * @return \Rakut\ExperienceBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param \Rakut\ExperienceBundle\Entity\User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }
}
