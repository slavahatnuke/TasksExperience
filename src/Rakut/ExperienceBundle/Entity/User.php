<?php

namespace Rakut\ExperienceBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var \Rakut\ExperienceBundle\Entity\Task[]
     *
     * @ORM\OneToMany(targetEntity="Rakut\ExperienceBundle\Entity\Task", mappedBy="user", cascade={"persist"})
     */
    private  $tasks;

    public function __construct()
    {
        parent::__construct();
        $this->tasks = new ArrayCollection();
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

    public function addTask(Task $task)
    {
        $this->tasks[] = $task;
        $task->setUser($this);
        return $this;
    }

    /**
     * Get task
     *
     * @return Collection|Task[]
     */
    public function getTasks()
    {
        return $this->tasks;
    }
}
