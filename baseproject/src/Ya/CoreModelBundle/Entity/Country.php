<?php

namespace Ya\CoreModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\AccessType;
use Ya\CoreModelBundle\Entity\Region as Region;

/**
 * Country
 *
 * @ORM\Table(name="country")
 * @ORM\Entity(repositoryClass="Ya\CoreModelBundle\Entity\Repository\CountryRepository")
 * @ExclusionPolicy("none")
 */
class Country
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
   * @ORM\Column(name="name", type="string", length=50, nullable=false)
   */
  protected $name;

  /**
   * @var string
   *
   * @ORM\Column(name="FIPS104", type="string", length=2, nullable=false)
   */
  protected $fips104;

  /**
   * @var string
   *
   * @ORM\Column(name="ISO2", type="string", length=2, nullable=false)
   */
  protected $iso2;

  /**
   * @var string
   *
   * @ORM\Column(name="ISO3", type="string", length=3, nullable=false)
   */
  protected $iso3;

  /**
   * @var string
   *
   * @ORM\Column(name="ISON", type="string", length=4, nullable=false)
   */
  protected $ison;

  /**
   * @var string
   *
   * @ORM\Column(name="capital", type="string", length=25, nullable=true)
   */
  protected $capital;

  /**
   * @var string
   *
   * @ORM\Column(name="map_reference", type="string", length=50, nullable=true)
   */
  protected $mapReference;

  /**
   * @var integer
   *
   * @ORM\Column(name="population", type="bigint", nullable=true)
   */
  protected $population;

  /**
   * @var ArrayCollection
   * @ORM\OneToMany(targetEntity="Region", mappedBy="country")
   */
  protected $regions;

  /**
   * @var ArrayCollection
   * @ORM\OneToMany(targetEntity="City", mappedBy="country")
   */
  protected $cities;

  /**
   * Constructor
   */
  public function __construct()
  {
    $this->regions = new \Doctrine\Common\Collections\ArrayCollection();
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
   * @return Country
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
   * Set fips104
   *
   * @param string $fips104
   * @return Country
   */
  public function setFips104($fips104)
  {
    $this->fips104 = $fips104;

    return $this;
  }

  /**
   * Get fips104
   *
   * @return string
   */
  public function getFips104()
  {
    return $this->fips104;
  }

  /**
   * Set iso2
   *
   * @param string $iso2
   * @return Country
   */
  public function setIso2($iso2)
  {
    $this->iso2 = $iso2;

    return $this;
  }

  /**
   * Get iso2
   *
   * @return string
   */
  public function getIso2()
  {
    return $this->iso2;
  }

  /**
   * Set iso3
   *
   * @param string $iso3
   * @return Country
   */
  public function setIso3($iso3)
  {
    $this->iso3 = $iso3;

    return $this;
  }

  /**
   * Get iso3
   *
   * @return string
   */
  public function getIso3()
  {
    return $this->iso3;
  }

  /**
   * Set ison
   *
   * @param string $ison
   * @return Country
   */
  public function setIson($ison)
  {
    $this->ison = $ison;

    return $this;
  }

  /**
   * Get ison
   *
   * @return string
   */
  public function getIson()
  {
    return $this->ison;
  }

  /**
   * Set capital
   *
   * @param string $capital
   * @return Country
   */
  public function setCapital($capital)
  {
    $this->capital = $capital;

    return $this;
  }

  /**
   * Get capital
   *
   * @return string
   */
  public function getCapital()
  {
    return $this->capital;
  }

  /**
   * Set mapReference
   *
   * @param string $mapReference
   * @return Country
   */
  public function setMapReference($mapReference)
  {
    $this->mapReference = $mapReference;

    return $this;
  }

  /**
   * Get mapReference
   *
   * @return string
   */
  public function getMapReference()
  {
    return $this->mapReference;
  }

  /**
   * Set population
   *
   * @param integer $population
   * @return Country
   */
  public function setPopulation($population)
  {
    $this->population = $population;

    return $this;
  }

  /**
   * Get population
   *
   * @return integer
   */
  public function getPopulation()
  {
    return $this->population;
  }

  /**
   * Add regions
   *
   * @param \Ya\CoreModelBundle\Entity\Region $regions
   * @return Country
   */
  public function addRegion(\Ya\CoreModelBundle\Entity\Region $regions)
  {
    $this->regions[] = $regions;

    return $this;
  }

  /**
   * Remove regions
   *
   * @param \Ya\CoreModelBundle\Entity\Region $regions
   */
  public function removeRegion(\Ya\CoreModelBundle\Entity\Region $regions)
  {
    $this->regions->removeElement($regions);
  }

  /**
   * Get regions
   *
   * @return \Doctrine\Common\Collections\Collection
   */
  public function getRegions()
  {
    return $this->regions;
  }

    /**
     * Add cities
     *
     * @param \Ya\CoreModelBundle\Entity\City $cities
     * @return Country
     */
    public function addCitie(\Ya\CoreModelBundle\Entity\City $cities)
    {
        $this->cities[] = $cities;
    
        return $this;
    }

    /**
     * Remove cities
     *
     * @param \Ya\CoreModelBundle\Entity\City $cities
     */
    public function removeCitie(\Ya\CoreModelBundle\Entity\City $cities)
    {
        $this->cities->removeElement($cities);
    }

    /**
     * Get cities
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCities()
    {
        return $this->cities;
    }
}