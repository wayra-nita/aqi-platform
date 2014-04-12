<?php

namespace Ya\CoreModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ya\CoreModelBundle\Entity\Region as Region;

/**
 * City
 *
 * @ORM\Table(name="city")
 * @ORM\Entity(repositoryClass="Ya\CoreModelBundle\Entity\Repository\CityRepository")
 */
class City
{
  /**
   * @var integer
   *
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="IDENTITY")
   */
  protected $id;

  /**
   * @var integer
   *
   * @ORM\Column(name="country_id", type="integer", nullable=false)
   */
  protected $countryId;

  /**
   * @var integer
   *
   * @ORM\Column(name="region_id", type="integer", nullable=false)
   */
  protected $regionId;

  /**
   * @var string
   *
   * @ORM\Column(name="name", type="string", length=45, nullable=false)
   */
  protected $name;

  /**
   * @var float
   *
   * @ORM\Column(name="latitude", type="float", precision=10, scale=0, nullable=false)
   */
  protected $latitude;

  /**
   * @var float
   *
   * @ORM\Column(name="longitude", type="float", precision=10, scale=0, nullable=false)
   */
  protected $longitude;

  /**
   * @var string
   *
   * @ORM\Column(name="time_zone", type="string", length=10, nullable=false)
   */
  protected $timeZone;

  /**
   * @var string
   *
   * @ORM\Column(name="code", type="string", length=5, nullable=true)
   */
  protected $code;

  /**
   * @var Region
   *
   * @ORM\ManyToOne(targetEntity="Region", inversedBy="cities")
   * @ORM\JoinColumn(name="region_id", referencedColumnName="id")
   */
  protected $region;

  /**
   * @var ArrayCollection
   * @ORM\OneToMany(targetEntity="ReportingArea", mappedBy="city")
   */
  protected $reportingAreas;

  /**
   * Constructor
   */
  public function __construct()
  {
    $this->reportingAreas = new \Doctrine\Common\Collections\ArrayCollection();
  }

  /**
   * Get id
   *
   * @return integer
   */
  public function getId()
  {
    return $this->id;
  }

  /**
   * Set countryId
   *
   * @param integer $countryId
   * @return City
   */
  public function setCountryId($countryId)
  {
    $this->countryId = $countryId;

    return $this;
  }

  /**
   * Get countryId
   *
   * @return integer
   */
  public function getCountryId()
  {
    return $this->countryId;
  }

  /**
   * Set regionId
   *
   * @param integer $regionId
   * @return City
   */
  public function setRegionId($regionId)
  {
    $this->regionId = $regionId;

    return $this;
  }

  /**
   * Get regionId
   *
   * @return integer
   */
  public function getRegionId()
  {
    return $this->regionId;
  }

  /**
   * Set name
   *
   * @param string $name
   * @return City
   */
  public function setName($name)
  {
    $this->name = $name;

    return $this;
  }

  /**
   * Get name
   *
   * @return string
   */
  public function getName()
  {
    return $this->name;
  }

  /**
   * Set latitude
   *
   * @param float $latitude
   * @return City
   */
  public function setLatitude($latitude)
  {
    $this->latitude = $latitude;

    return $this;
  }

  /**
   * Get latitude
   *
   * @return float
   */
  public function getLatitude()
  {
    return $this->latitude;
  }

  /**
   * Set longitude
   *
   * @param float $longitude
   * @return City
   */
  public function setLongitude($longitude)
  {
    $this->longitude = $longitude;

    return $this;
  }

  /**
   * Get longitude
   *
   * @return float
   */
  public function getLongitude()
  {
    return $this->longitude;
  }

  /**
   * Set timeZone
   *
   * @param string $timeZone
   * @return City
   */
  public function setTimeZone($timeZone)
  {
    $this->timeZone = $timeZone;

    return $this;
  }

  /**
   * Get timeZone
   *
   * @return string
   */
  public function getTimeZone()
  {
    return $this->timeZone;
  }

  /**
   * Set code
   *
   * @param string $code
   * @return City
   */
  public function setCode($code)
  {
    $this->code = $code;

    return $this;
  }

  /**
   * Get code
   *
   * @return string
   */
  public function getCode()
  {
    return $this->code;
  }

  /**
   * Set region
   *
   * @param \Ya\CoreModelBundle\Entity\Region $region
   * @return City
   */
  public function setRegion(\Ya\CoreModelBundle\Entity\Region $region = null)
  {
    $this->region = $region;

    return $this;
  }

  /**
   * Get region
   *
   * @return \Ya\CoreModelBundle\Entity\Region
   */
  public function getRegion()
  {
    return $this->region;
  }

  /**
   * Add reportingAreas
   *
   * @param \Ya\CoreModelBundle\Entity\ReportingArea $reportingAreas
   * @return City
   */
  public function addReportingArea(\Ya\CoreModelBundle\Entity\ReportingArea $reportingAreas)
  {
    $this->reportingAreas[] = $reportingAreas;

    return $this;
  }

  /**
   * Remove reportingAreas
   *
   * @param \Ya\CoreModelBundle\Entity\ReportingArea $reportingAreas
   */
  public function removeReportingArea(\Ya\CoreModelBundle\Entity\ReportingArea $reportingAreas)
  {
    $this->reportingAreas->removeElement($reportingAreas);
  }

  /**
   * Get reportingAreas
   *
   * @return \Doctrine\Common\Collections\Collection
   */
  public function getReportingAreas()
  {
    return $this->reportingAreas;
  }
}