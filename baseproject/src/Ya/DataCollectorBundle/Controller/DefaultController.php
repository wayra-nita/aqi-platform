<?php

namespace Ya\DataCollectorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/res/{name}")
     * @Method("GET")
     * @Template()
     */
    public function indexAction($name)
    {
      $collector = $this->container->get('collector.airnow');
      $collector->collectData();
      die('bla');
    }
}
