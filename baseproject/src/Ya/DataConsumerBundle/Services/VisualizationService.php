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

class VisualizationService extends AbstractConsumerService {

    public function getCountInQuadrant($neLat, $neLng, $swLat, $swLng) {
        $count = $this->em->getRepository('YaCoreModelBundle:Observation')->getCountInQuadrant(
                $neLat, $neLng, $swLat, $swLng);
        return $count;
    }

    public function getAverageByQuadrant($neLat, $neLng, $swLat, $swLng) {
        $average = $this->em->getRepository('YaCoreModelBundle:Observation')->getByQuadrant(
                $neLat, $neLng, $swLat, $swLng);
        return $average;
    }

    public function getResourcesByQuadrant($neLat, $neLng, $swLat, $swLng) {
      return $this->em->getRepository('YaCoreModelBundle:Resource')->getByQuadrant(
        $neLat, $neLng, $swLat, $swLng);
    }
    
    public function initialize() {
        
    }
}
