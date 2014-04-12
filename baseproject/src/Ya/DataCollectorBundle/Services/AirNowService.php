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
  const COUNTRY_CODE = 'US';
  const PARTNER_NAME = 'AirNow';
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
    $partner = $this->em->getRepository('YaCoreModelBundle:Partner')->findOneByName(self::PARTNER_NAME);
    $path = $this->kernel->locateResource('@YaDataCollectorBundle/Resources/downloads/' . self::FILE_PATH);
    $handle = fopen($path, "r");

    if ($handle)
    {
      $count = 0;
      while (($line = fgets($handle)) !== false)
      {
        $this->parseLine($line, $partner);
        if ($count % 500 == 0)
        {
          $this->em->flush();
        }
        $count++;
      }
    }
    else
    {
      return self::RESULT_UNABLE_TO_OPEN_FILE;
    }
    fclose($handle);
    $this->em->flush();
    return self::RESULT_OK;
  }

  protected function parseLine($line, $partner)
  {
    // Fields description at Resources/doc/ReportingAreaFactSheet.pdf
    $fields = explode('|', $line);
    if (count($fields) !== self::FIELDS_COUNT_EXPECTED)
    {
      return; // Ignore lines with wrong format. TODO: Generate an alert or something
    }

    $observation = new Observation();
    $observation->setPartner($partner);
    $observation->setIssueDate(new \DateTime($fields[0]));
    $observation->setValidDate(new \DateTime($fields[1] . ' ' . $fields[2]));
    $observation->setTimeZone($fields[3]);
    $sequence = $this->em->getRepository('YaCoreModelBundle:SequenceEnum')->findOneById($fields[4]);
    $observation->setSequence($sequence);
    $dataType = $this->em->getRepository('YaCoreModelBundle:DataTypeEnum')->findOneByCode($fields[5]);
    $observation->setDataType($dataType);
    $observation->setIsPrimary($fields[6] == 'Y');
    $cityName = trim($fields[7]);
    $regionCode = trim($fields[8]);
    $latitude = trim($fields[9]);
    $longitude = trim($fields[10]);
    $reportingArea = $this->em->getRepository('YaCoreModelBundle:ReportingArea')->
      getOrCreateReportingArea(self::COUNTRY_CODE, $regionCode, $cityName, $latitude, $longitude);
    $observation->setReportingArea(($reportingArea));
    $observation->setParameterName($fields[11]);
    $observation->setAqiValue($fields[12]);
    $aqiCategory = $this->em->getRepository('YaCoreModelBundle:AirQualityCategory')->findOneByName($fields[13]);
    $observation->setAirQualityCategory($aqiCategory);
    $observation->setIsActionDay($fields[14] == 'Yes');
    $observation->setDiscussion(trim($fields[15]));
    $observation->setForecastSource(trim($fields[16]));
    $this->em->persist($observation);
  }

}
