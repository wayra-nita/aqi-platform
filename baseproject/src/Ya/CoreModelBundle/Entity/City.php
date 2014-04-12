<?php

namespace Ya\CoreModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\AccessType;
use Ya\CoreModelBundle\Entity\Region as Region;

/**
 * City
 *
 * @ORM\Table(name="city")
 * @ORM\Entity(repositoryClass="Ya\CoreModelBundle\Entity\Repository\CityRepository")
 * @ExclusionPolicy("none")
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
   * @var string
   *
   * @ORM\Column(name="name", type="string", length=45, nullable=false)
   */
  protected $name;

  /**
   * @var float
   *
   * @ORM\Column(name="latitude", type="float", nullable=true)
   */
  protected $latitude;

  /**
   * @var float
   *
   * @ORM\Column(name="longitude", type="float", nullable=true)
   */
  protected $longitude;

  /**
   * @var string
   *
   * @ORM\Column(name="time_zone", type="string", length=10, nullable=true)
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
   * @var Country
   *
   * @ORM\ManyToOne(targetEntity="Country", inversedBy="cities")
   * @ORM\JoinColumn(name="country_id", referencedColumnName="id")
   */
  protected $country;

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
     * Set country
     *
     * @param \Ya\CoreModelBundle\Entity\Country $country
     * @return City
     */
    public function setCountry(\Ya\CoreModelBundle\Entity\Country $country = null)
    {
        $this->country = $country;
    
        return $this;
    }

    /**
     * Get country
     *
     * @return \Ya\CoreModelBundle\Entity\Country 
     */
    public function getCountry()
    {
        return $this->country;
    }
}