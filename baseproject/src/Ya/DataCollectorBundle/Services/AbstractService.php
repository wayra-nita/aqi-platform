<?php
/**
 * AbstractService
 *
 * @author Steven Rojas <steven.rojas@gmail.com>
 */
namespace Ya\DataCollectorBundle\Services;

use Ya\DataCollectorBundle\Interfaces\IDataCollector as IDataCollector;

abstract class AbstractService implements IDataCollector
{
  const RESULT_OK = 'OK';
  const RESULT_UNABLE_TO_OPEN_FILE = 'UNABLE_TO_OPEN_FILE';
  const RESULT_UNABLE_TO_DOWNLOAD = 'UNABLE_TO_DOWNLOAD';
  const RESULT_WRONG_SCHEMA = 'WRONG_SCHEMA';

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