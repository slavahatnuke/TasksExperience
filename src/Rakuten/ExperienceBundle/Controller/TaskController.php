<?php

namespace Rakuten\ExperienceBundle\Controller;

use Rakuten\ExperienceBundle\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TaskController extends Controller
{
    /**
     * @Rest\View
     */
    public function allAction()
    {
        $tasks = $this->getTaskRepository()->findAll();

        return array('tasks' => $tasks);
    }

    /**
     * @Rest\View
     */
    public function getAction($id)
    {
        $task = $this->getTaskRepository()->findOneById($id);

        if (!$task instanceof Task) {
            throw new NotFoundHttpException('Task not found');
        }

        return array('task' => $task);
    }

    /**
     * @return \Rakuten\ExperienceBundle\Entity\TaskRepository
     */
    private function getTaskRepository()
    {
        return $this->container->get('repository.task');
    }

} 