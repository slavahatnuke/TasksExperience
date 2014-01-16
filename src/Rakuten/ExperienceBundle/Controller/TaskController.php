<?php

namespace Rakuten\ExperienceBundle\Controller;

use Rakuten\ExperienceBundle\Entity\Task;
use Rakuten\ExperienceBundle\Form\TaskType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

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
     * @Rest\View(statusCode=204)
     */
    public function newAction(Task $task)
    {
        $statusCode = $task->isNew() ? 201 : 204;

        $form = $this->createForm(new TaskType(), $task);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $task = $form->getData();
            $em = $this->getDoctrine()->getManager();

            $em->persist($task);

            $em->flush();

            $response = new Response();
            $response->setStatusCode($statusCode);

            // set the `Location` header only when creating new resources
            if (201 === $statusCode) {
                $response->headers->set('Location',
                    $this->generateUrl(
                        'rakuten_experience_task_get', array('id' => $task->getId()),
                        true // absolute
                    )
                );
            }

            return $response;
        }

        return $this->render('RakutenExperienceBundle:Default:taskform.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Rest\View(statusCode=204)
     */
    public function putAction($id)
    {
        $task = $this->getTaskRepository()->findOneById($id);

        if (!$task instanceof Task) {
            throw new NotFoundHttpException('Task not found');
        }

        $form = $this->createForm(new TaskType(), $task);
        $form->submit($this->getRequest()->request->all());

        if ($form->isValid()) {
            $this->getDoctrine()->getManager()->persist($task);
            $this->getDoctrine()->getManager()->flush();

            return array();
        }

        return $form;
    }

    /**
     * @Rest\View(statusCode=204)
     */
    public function removeAction($id)
    {
        $task = $this->getTaskRepository()->findOneById($id);
        $this->getDoctrine()->getManager()->remove($task);
        $this->getDoctrine()->getManager()->flush();
    }


    /**
     * @return \Rakuten\ExperienceBundle\Entity\TaskRepository
     */
    private function getTaskRepository()
    {
        return $this->container->get('repository.task');
    }

} 