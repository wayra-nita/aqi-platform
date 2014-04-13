<?php

namespace Ya\CoreModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ya\CoreModelBundle\Entity\Observation as Observation;

/**
 * AirQualityCategory
 *
 * @ORM\Table("air_quality_category_enum")
 * @ORM\Entity(repositoryClass="Ya\CoreModelBundle\Entity\Repository\AirQualityCategoryRepository")
 */
class AirQualityCategory
{
  /**
   * @var integer
   *
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  protected $id;

  /**
   * @var string
   *
   * @ORM\Column(name="name", type="string", length=30)
   */
  protected $name;

  /**
   * @var string
   *
   * @ORM\Column(name="color_code", type="string", length=10)
   */
  protected $colorCode;

  /**
   * @var integer
   *
   * @ORM\Column(name="min", type="integer")
   */
  protected $min;

  /**
   * @var integer
   *
   * @ORM\Column(name="max", type="integer")
   */
  protected $max;

  /**
   * @var ArrayCollection
   * @ORM\OneToMany(targetEntity="Observation", mappedBy="airQualityCategory")
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
   * Set name
   *
   * @param string $name
   * @return AirQualityCategory
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
   * Set colorCode
   *
   * @param string $colorCode
   * @return AirQualityCategory
   */
  public function setColorCode($colorCode)
  {
    $this->colorCode = $colorCode;

    return $this;
  }

  /**
   * Get colorCode
   *
   * @return string
   */
  public function getColorCode()
  {
    return $this->colorCode;
  }

  /**
   * Add observations
   *
   * @param \Ya\CoreModelBundle\Entity\Observation $observations
   * @return AirQualityCategory
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
     * Set min
     *
     * @param integer $min
     * @return AirQualityCategory
     */
    public function setMin($min)
    {
        $this->min = $min;
    
        return $this;
    }

    /**
     * Get min
     *
     * @return integer 
     */
    public function getMin()
    {
        return $this->min;
    }

    /**
     * Set max
     *
     * @param integer $max
     * @return AirQualityCategory
     */
    public function setMax($max)
    {
        $this->max = $max;
    
        return $this;
    }

    /**
     * Get max
     *
     * @return integer 
     */
    public function getMax()
    {
        return $this->max;
    }
}