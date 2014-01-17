<?php

namespace Rakut\ExperienceBundle\Controller;

use Rakut\ExperienceBundle\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('RakutExperienceBundle:Default:index.html.twig');
    }

}
