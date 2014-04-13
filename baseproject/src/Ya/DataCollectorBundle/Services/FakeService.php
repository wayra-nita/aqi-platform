<?php
/**
 * FakeService
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

class FakeService extends AbstractService
{
  const PARTNER_NAME = 'Fake Partner';

  public function collectData($countryCode)
  {
    $partner = $this->em->getRepository('YaCoreModelBundle:Partner')->findOneByName(self::PARTNER_NAME);
    $country = $this->em->getRepository('YaCoreModelBundle:Country')->findOneBy(array('iso2' => $countryCode));
    $cities = $this->em->getRepository('YaCoreModelBundle:City')->findBy(array('country' => $country->getId()));
    foreach ($cities as $city)
    {
      $lat = $city->getLatitude();
      $lon = $city->getLongitude();
      $distance = 5;
      for ($i = 0; $i < 5; $i++)
      {
        $aqi = rand(20, 160);
        $boundary = $this->getBoundary($lat, $lon, $distance);
        $this->createObservation($partner, $city, $countryCode, $aqi, $boundary['maxLat'], $boundary['maxLon']);
        $this->createObservation($partner, $city, $countryCode, $aqi, $boundary['minLat'], $boundary['minLon']);
        $distance = $distance + 5;
      }
      $this->em->flush();
    }
    return self::RESULT_OK;
  }

  protected function createObservation($partner, $city, $countryCode, $aqi, $lat, $lon)
  {
    $observation = new Observation();
    $observation->setPartner($partner);
    $observation->setIssueDate(new \DateTime());
    $observation->setValidDate(new \DateTime());
    $observation->setTimeZone($city->getTimeZone());
    $sequence = $this->em->getRepository('YaCoreModelBundle:SequenceEnum')->findOneById(0);
    $observation->setSequence($sequence);
    $dataType = $this->em->getRepository('YaCoreModelBundle:DataTypeEnum')->findOneByCode('O');
    $observation->setDataType($dataType);
    $observation->setIsPrimary(true);
    $cityName = $city->getName();
    $regionCode = $city->getRegion()->getCode();
    $latitude = $lat;
    $longitude = $lon;
    $reportingArea = $this->em->getRepository('YaCoreModelBundle:ReportingArea')->
      getOrCreateReportingArea($countryCode, $regionCode, $cityName, $latitude, $longitude);
    $observation->setReportingArea(($reportingArea));
    $observation->setParameterName('PM2.5');
    $observation->setAqiValue($aqi);
    $aqiCategory = $this->em->getRepository('YaCoreModelBundle:AirQualityCategory')->getByAqiValue($aqi);
    $aqiCategory = $aqiCategory[0];
    $observation->setAirQualityCategory($aqiCategory);
    $observation->setIsActionDay(true);
    $observation->setDiscussion('');
    $observation->setForecastSource('Fake data');
    $this->em->persist($observation);
  }

  protected function getBoundary($lat, $lng, $distance)
  {
    /**
     * SELECT id, (3959 * acos(cos(radians(19)) * cos(radians(latitude)) * cos(radians(longitude) - radians(-155)) + sin(radians(37)) * sin(radians(latitude)))) AS distance FROM reporting_area HAVING distance < 25 ORDER BY distance LIMIT 0,20;
     */
    $radius = 3958.761;

    // latitude boundaries
    $maxLat = (float) $lat + rad2deg($distance / $radius);
    $minLat = (float) $lat - rad2deg($distance / $radius);

    // longitude boundaries
    $maxLng = ((float)$lng + rad2deg($distance / $radius)) / cos(deg2rad((float)$lat));
    $minLng = ((float) $lng - rad2deg($distance / $radius)) / cos(deg2rad((float)$lat));

    $boundary = array(
      'maxLat' => $maxLat,
      'minLat' => $minLat,
      'maxLon' => $maxLng,
      'minLon' => $minLng
    );

    return $boundary;
  }

  protected function initialize()
  {

  }

}
