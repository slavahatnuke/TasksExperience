<?php

namespace Rakuten\ExperienceBundle\Controller;

use Rakuten\ExperienceBundle\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('RakutenExperienceBundle:Default:index.html.twig');
    }

    public function testAction()
    {
        return $this->render('RakutenExperienceBundle:Default:index2.html.twig');
    }

    public function newAction()
    {

    }
}
