<?php

namespace Air\WebAppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render("AirWebAppBundle:Default:index.html.twig", array());
    }
}
