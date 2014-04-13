<?php

namespace Ya\CoreModelBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Ya\CoreModelBundle\Entity\ReportingArea as ReportingArea;

/**
 * ReportingAreaRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ReportingAreaRepository extends EntityRepository
{
  public function getOrCreateReportingArea($countryCode, $regionCode, $cityName, $latitude, $longitude)
  {
    $em = $this->getEntityManager();
    $country = $em->getRepository('YaCoreModelBundle:Country')->findOneBy(array('iso2' => $countryCode));
    $region = $em->getRepository('YaCoreModelBundle:Region')->
      getOrCreateRegionByCountry($country, $regionCode);
    $city = $em->getRepository('YaCoreModelBundle:City')->
      getOrCreateCityByRegionAndCountry($country, $region, $cityName, $latitude, $longitude);
    $reportingArea = $em->getRepository('YaCoreModelBundle:ReportingArea')->findOneBy(
      array('city' => $city->getId(), 'areaName' => $cityName, 'latitude' => $latitude, 'longitude' => $longitude));
    if (!$reportingArea)
    {
      $reportingArea = new ReportingArea();
      $reportingArea->setCity($city);
      $reportingArea->setAreaName($cityName);
      $reportingArea->setLatitude($latitude);
      $reportingArea->setLongitude($longitude);
      $em->persist($reportingArea);
      $em->flush();
    }
    return $reportingArea;
  }
}
