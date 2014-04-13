<?php

namespace Ya\DataCollectorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/airdata")
     * @Method("GET")
     * @Template()
     * TODO: Move this to a console application and execute it as cron
     */
    public function indexAction()
    {
      $collector = $this->container->get('collector.airnow');
      $collector->collectData();
      die('Airdata parsed successfully');
    }

  /**
   * @Route("/fake/{country}")
   * @Method("GET")
   * @Template()
   */
  public function fakeAction($country)
  {
    $collector = $this->container->get('collector.fake');
    $collector->collectData($country);
    die('Fake data generated for ' . $country);
  }
}
