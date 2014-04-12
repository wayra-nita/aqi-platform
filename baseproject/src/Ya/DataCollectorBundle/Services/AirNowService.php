<?php
/**
 * AirNowService
 *
 * @author Steven Rojas <steven.rojas@gmail.com>
 */

namespace Ya\DataCollectorBundle\Services;


use Symfony\Component\Config\Definition\Exception\Exception;
use Ya\CoreModelBundle\Entity\AirQualityCategory as AirQualityCategory;
use Ya\CoreModelBundle\Entity\DataTypeEnum as DataTypeEnum;
use Ya\CoreModelBundle\Entity\Observation as Observation;
use Ya\CoreModelBundle\Entity\Partner as Partner;
use Ya\CoreModelBundle\Entity\ReportingArea as ReportingArea;
use Ya\CoreModelBundle\Entity\SequenceEnum as SequenceEnum;

 class AirNowService extends AbstractService
{
  const FILE_PATH = 'airnow/reportingarea.dat';
  const FIELDS_COUNT_EXPECTED = 17;
  /**
   * @var Doctrine\ORM\EntityManager
   */
  private $em;

  /**
   * @var Symfony\Component\HttpKernel
   */
  private $kernel;

  /**
   * @var array
   */
  private $parsedData = array();

  public function __construct($em, $kernel)
  {
    $this->em = $em;
    $this->kernel = $kernel;
    $this->initialize();
  }

  public function collectData()
  {
    $result = $this->downloadFile();
    if ($result != self::RESULT_OK)
    {
      return $result;
    }
    $this->parseFile();
    $airQualityCategory = $this->em->getRepository('YaCoreModelBundle:AirQualityCategory')->findOneById(1);
    var_dump($airQualityCategory); exit;
    die('collect');
  }

  protected function initialize()
  {

  }

  protected function downloadFile()
  {
    return self::RESULT_OK;
  }

  protected function parseFile()
  {
    $path = $this->kernel->locateResource('@YaDataCollectorBundle/Resources/downloads/' . self::FILE_PATH);
    $handle = fopen($path, "r");
    if ($handle)
    {
      while (($line = fgets($handle)) !== false)
      {
        $this->parseLine($line);
      }
    }
    else
    {
      return self::RESULT_UNABLE_TO_OPEN_FILE;
    }
    fclose($handle);
    return self::RESULT_OK;
  }

  protected function parseLine($line)
  {
    // Fields description at Resources/doc/ReportingAreaFactSheet.pdf
    $fields = explode('|', $line);
    if (count($fields) !== self::FIELDS_COUNT_EXPECTED)
    {
      return; // Ignore lines with wrong format. TODO: Generate an alert or something
    }

    $observation = new Observation();
    $observation->setIssueDate(new \DateTime($fields[0]));
    $observation->setValidDate(new \DateTime($fields[1] . ' ' . $fields[2]));
    //$observation->set


    $observation->setAirQualityCategory();
  }

}