<?php

namespace Ya\CoreModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ya\CoreModelBundle\Entity\City as City;
use Ya\CoreModelBundle\Entity\Observation as Observation;

/**
 * ReportingArea
 *
 * @ORM\Table("reporting_area")
 * @ORM\Entity(repositoryClass="Ya\CoreModelBundle\Entity\Repository\ReportingAreaRepository")
 */
class ReportingArea
{
  /**
   * @var integer
   *
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   *
   */
  protected $id;

  /**
   * @var string
   *
   * @ORM\Column(name="area_name", type="string", length=100)
   */
  protected $areaName;

  /**
   * @var string
   *
   * @ORM\Column(name="latitude", type="float")
   */
  protected $latitude;

  /**
   * @var string
   *
   * @ORM\Column(name="longitude", type="float")
   */
  protected $longitude;

  /**
   * @var City
   *
   * @ORM\ManyToOne(targetEntity="City", inversedBy="reportingAreas")
   * @ORM\JoinColumn(name="city_id", referencedColumnName="id")
   */
  protected $city;

  /**
   * @var ArrayCollection
   * @ORM\OneToMany(targetEntity="Observation", mappedBy="reportingArea")
   */
  protected $observations;

  /**
   * Constructor
   */
  public function __construct()
  {
    $this->observations = new \Doctrine\Common\Collections\ArrayCollection();
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
   * Set areaName
   *
   * @param string $areaName
   * @return ReportingArea
   */
  public function setAreaName($areaName)
  {
    $this->areaName = $areaName;

    return $this;
  }

  /**
   * Get areaName
   *
   * @return string
   */
  public function getAreaName()
  {
    return $this->areaName;
  }

  /**
   * Set city
   *
   * @param \Ya\CoreModelBundle\Entity\City $city
   * @return ReportingArea
   */
  public function setCity(\Ya\CoreModelBundle\Entity\City $city = null)
  {
    $this->city = $city;

    return $this;
  }

  /**
   * Get city
   *
   * @return \Ya\CoreModelBundle\Entity\City
   */
  public function getCity()
  {
    return $this->city;
  }

  /**
   * Add observations
   *
   * @param \Ya\CoreModelBundle\Entity\Observation $observations
   * @return ReportingArea
   */
  public function addObservation(\Ya\CoreModelBundle\Entity\Observation $observations)
  {
    $this->observations[] = $observations;

    return $this;
  }

  /**
   * Remove observations
   *
   * @param \Ya\CoreModelBundle\Entity\Observation $observations
   */
  public function removeObservation(\Ya\CoreModelBundle\Entity\Observation $observations)
  {
    $this->observations->removeElement($observations);
  }

  /**
   * Get observations
   *
   * @return \Doctrine\Common\Collections\Collection
   */
  public function getObservations()
  {
    return $this->observations;
  }

    /**
     * Set latitude
     *
     * @param float $latitude
     * @return ReportingArea
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
     * @return ReportingArea
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
}