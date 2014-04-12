<?php

namespace Ya\CoreModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\AccessType;
use Ya\CoreModelBundle\Entity\Observation as Observation;

/**
 * DataTypeEnum
 *
 * @ORM\Table("data_type_enum")
 * @ORM\Entity(repositoryClass="Ya\CoreModelBundle\Entity\Repository\DataTypeEnumRepository")
 * @ExclusionPolicy("none")
 */
class DataTypeEnum
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
   * @ORM\Column(name="code", type="string", length=10)
   */
  protected $code;

  /**
   * @var string
   *
   * @ORM\Column(name="description", type="string", length=100)
   */
  protected $description;

  /**
   * @var ArrayCollection
   * @ORM\OneToMany(targetEntity="Observation", mappedBy="dataType")
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
   * Set string
   *
   * @param string $string
   * @return DataTypeEnum
   */
  public function setString($string)
  {
    $this->string = $string;

    return $this;
  }

  /**
   * Get string
   *
   * @return string
   */
  public function getString()
  {
    return $this->string;
  }

  /**
   * Add observations
   *
   * @param \Ya\CoreModelBundle\Entity\Observation $observations
   * @return DataTypeEnum
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
     * Set code
     *
     * @param string $code
     * @return DataTypeEnum
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
     * Set description
     *
     * @param string $description
     * @return DataTypeEnum
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }
}