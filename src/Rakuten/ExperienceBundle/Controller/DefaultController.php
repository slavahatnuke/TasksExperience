<?php

namespace Rakuten\ExperienceBundle\Controller;

use Rakuten\ExperienceBundle\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        $task = new Task();
        $task->setTitle('task number one');
        $task->setIsDone(true);
        $em = $this->getDoctrine()->getManager();

        $em->persist($task);

        $em->flush();

        return $this->render('RakutenExperienceBundle:Default:index.html.twig', array('name' => $name));
    }
}
