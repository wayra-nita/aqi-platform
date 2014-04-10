<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ya\CoreModelBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture as AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Ya\CoreModelBundle\Entity\Test;

/**
 * Owner: Jonathan Claros 
 */

class LoadTestData extends AbstractFixture implements OrderedFixtureInterface
{
  public function load(ObjectManager $manager){
    
    for($i = 0; $i < 10 ; $i ++){

      $entity = new Test();
      $entity->setTitle("Test Nr ". ($i+1));
      $entity->setDescription(" This is the description of the element ");
      $manager->persist($entity);
    }

    $manager->flush();

  }

  public function getOrder(){
    return 2;
  }
}
