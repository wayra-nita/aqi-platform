<?php
/**
 * VisualizationService
 *
 * @author Steven Rojas <steven.rojas@gmail.com>
 */
namespace Ya\DataConsumerBundle\Services;

use Symfony\Component\Config\Definition\Exception\Exception;
use Ya\CoreModelBundle\Entity\AirQualityCategory as AirQualityCategory;
use Ya\CoreModelBundle\Entity\DataTypeEnum as DataTypeEnum;
use Ya\CoreModelBundle\Entity\Observation as Observation;
use Ya\CoreModelBundle\Entity\Partner as Partner;
use Ya\CoreModelBundle\Entity\ReportingArea as ReportingArea;
use Ya\CoreModelBundle\Entity\SequenceEnum as SequenceEnum;


class VisualizationService extends AbstractConsumerService
{
  public function getAverageByCountry()
  {
    $observations = $this->em->getRepository('YaCoreModelBundle:Observation')->getById(12670);
    return $observations;
  }
  protected function initialize()
  {

  }
} 