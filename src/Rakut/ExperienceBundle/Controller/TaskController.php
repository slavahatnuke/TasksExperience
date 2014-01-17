<?php

namespace Rakut\ExperienceBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use Rakut\ExperienceBundle\Entity\User;

class TaskController extends RestController
{
    /**
     * @Rest\View
     */
    public function getTasksAction()
    {
        /** @var $user User */
        $user = $this->getUser();
        $this->forward401UnlessAuthenticatedUser();
        $tasks = $user->getTasks();

        return array('tasks' => $tasks);
    }

    /**
     * @Rest\View
     */
    public function getTaskAction($id)
    {
        /** @var $user User */
        $user = $this->getUser();
        $this->forward401UnlessAuthenticatedUser();
        $this->forward404Unless($task = $user->getTasks()->get($id), 'Task was not found');

        return array('task' => $task);
    }

    /**
     * @Rest\View()
     *
     * @return array
     */
    public function postTasksAction()
    {
        /** @var $user User */
        $user = $this->getUser();
        $this->forward401UnlessAuthenticatedUser();

        $form = $this->createForm('task');
        $form->submit($this->getRequest()->request->all());

        if ($form->isValid()) {
            $task = $form->getData();
            $user->addTask($task);
            $this->getDoctrine()->getManager()->persist($task);
            $this->getDoctrine()->getManager()->flush();

            return $task;
        }

        return $form;
    }

    /**
     * @Rest\View()
     *
     * @param $id
     *
     * @return array
     */
    public function putTaskAction($id)
    {
        /** @var $user User */
        $user = $this->getUser();
        $this->forward401UnlessAuthenticatedUser();
        $this->forward404Unless($task = $this->getTaskRepository()->find($id), 'Task was not found');

        $form = $this->createForm('task', $task);
        $form->submit($this->getRequest()->request->all());

        if ($form->isValid()) {
            $task = $form->getData();
            $user->addTask($task);
            $this->getDoctrine()->getManager()->flush();

            return $task;
        }

        return $form;
    }

    /**
     * @Rest\View(statusCode=204)
     *
     * @param int $id
     */
    public function deleteTaskAction($id)
    {
        /** @var $user User */
        $user = $this->getUser();
        $this->forward401UnlessAuthenticatedUser();
        $this->forward404Unless($task = $this->getTaskRepository()->find($id), 'Task was not found');

        $this->getDoctrine()->getManager()->remove($task);
        $this->getDoctrine()->getManager()->flush();
    }

    /**
     * @Rest\View(statusCode=204)
     */
    public function deleteTasksAction()
    {
        /** @var $user User */
        $user = $this->getUser();
        $this->forward401UnlessAuthenticatedUser();

        $user->getTasks()->clear();
        $this->getDoctrine()->getManager()->flush();
    }

    /**
     * @return \Rakut\ExperienceBundle\Entity\TaskRepository
     */
    private function getTaskRepository()
    {
        return $this->container->get('repository.task');
    }
}