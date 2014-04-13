<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ya\DataCollectorBundle\Controller;

use Ya\CoreModelBundle\Entity\User;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\Prefix;
use FOS\RestBundle\Controller\Annotations\NamePrefix;
use FOS\RestBundle\View\RouteRedirectView;
use FOS\RestBundle\View\View AS FOSView;
use Symfony\Bundle\FrameworkBundle\Controller\Controller as SymfonyController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;


use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use FOS\RestBundle\Controller\Annotations\Options;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use FOS\RestBundle\Controller\Annotations\Route;

use Ya\CoreModelBundle\Entity\Resource;

/**
 * Controller that provides Restfuls security functions.
 *
 * @Prefix("/resource")
 * @NamePrefix("resource_rest_")
 * @author Jonathan Claros <andrew.hhb.cs@gmail.com>
 */
class ResourceController extends SymfonyController{
  /**
    * Demo API module working
    *
    * @return FOSView
    * Using param_fetcher_listener: force
    * @Route("/{id}", options={"expose"=true})
    * @param ParamFetcher $paramFetcher Paramfetcher
    *
    * @RequestParam(name="title", requirements="\d+", default="", description="Title of the image")
    * 
    * @ApiDoc()
    */
  public function getAction(Resource $test)
  {
    return $this->view($test);
  }
  
  /**
    * Demo API module working
    *
    * @return FOSView
    * Using param_fetcher_listener: force
    * @Route("/", options={"expose"=true})
    * @param ParamFetcher $paramFetcher Paramfetcher
    * @RequestParam(name="title", requirements="\d+", default="", description="Title of the image")
    * 
    * @ApiDoc()
    */
  public function postAction(Request $req)
  {
    $title = $req->get("title");
    $id = $req->get("id");
    $lat = $req->get("lat");
    $long = $req->get("long");
    $imgloc = $req->get("imgloc");
    
    $resource = $this->getDoctrine()
        ->getRepository('YaCoreModelBundle:Resource')
        ->findOneBySource($id);
    if(!($resource instanceof Resource)){
      $resource = new Resource();
    }else{
      return new \Symfony\Component\HttpFoundation\Response(json_encode(array("status"=>"already created")), 200);
    }
    
    $resource->setSource($id);
    $resource->setPath($imgloc);
    $resource->setName($title);
    $resource->setLongitude($long);
    $resource->setLatitude($lat);
    $resource->setDescription("file uploaded");
    
    $em = $this->getDoctrine()->getManager();
    $em->persist($resource);
    $em->flush();
    
    
    return new \Symfony\Component\HttpFoundation\Response(json_encode(array("status"=>"ok")), 200);
    
  }
  
  
}
