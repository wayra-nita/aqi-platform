<?php
/**
 * AbstractConsumerService
 *
 * @author Steven Rojas <steven.rojas@gmail.com>
 */
namespace Ya\DataConsumerBundle\Services;


abstract class AbstractConsumerService
{
  /**
   * @var Doctrine\ORM\EntityManager
   */
  protected $em;

  /**
   * @var Symfony\Component\HttpKernel
   */
  protected $kernel;

  public function __construct($em, $kernel)
  {
    $this->em = $em;
    $this->kernel = $kernel;
    $this->initialize();
  }
} 