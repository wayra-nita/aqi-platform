<?php

namespace Ya\CoreModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ya\CoreModelBundle\Entity\City as City;
use Ya\CoreModelBundle\Entity\Country as Country;

/**
 * Region
 *
 * @ORM\Table(name="region")
 * @ORM\Entity(repositoryClass="Ya\CoreModelBundle\Entity\Repository\RegionRepository")
 */
class Region
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
   * @var string
   *
   * @ORM\Column(name="name", type="string", length=45, nullable=false)
   */
  protected $name;

  /**
   * @var string
   *
   * @ORM\Column(name="code", type="string", length=8, nullable=true)
   */
  protected $code;

  /**
   * @var string
   *
   * @ORM\Column(name="ADM1Code", type="string", length=4, nullable=true)
   */
  protected $adm1code;

  /**
   * @var ArrayCollection
   * @ORM\OneToMany(targetEntity="City", mappedBy="region")
   */
  protected $cities;

  /**
   * @var Country
   *
   * @ORM\ManyToOne(targetEntity="Country", inversedBy="regions")
   * @ORM\JoinColumn(name="country_id", referencedColumnName="id")
   */
  protected $country;

  /**
   * Constructor
   */
  public function __construct()
  {
    $this->cities = new \Doctrine\Common\Collections\ArrayCollection();
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
   * @return Region
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
   * Set name
   *
   * @param string $name
   * @return Region
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
   * Set code
   *
   * @param string $code
   * @return Region
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
   * Set adm1code
   *
   * @param string $adm1code
   * @return Region
   */
  public function setAdm1code($adm1code)
  {
    $this->adm1code = $adm1code;

    return $this;
  }

  /**
   * Get adm1code
   *
   * @return string
   */
  public function getAdm1code()
  {
    return $this->adm1code;
  }

  /**
   * Add cities
   *
   * @param \Ya\CoreModelBundle\Entity\City $cities
   * @return Region
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

  /**
   * Set country
   *
   * @param \Ya\CoreModelBundle\Entity\Country $country
   * @return Region
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