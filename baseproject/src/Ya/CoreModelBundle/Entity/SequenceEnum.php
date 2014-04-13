<?php

namespace Ya\CoreModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ya\CoreModelBundle\Entity\Observation as Observation;

/**
 * SequenceEnum
 *
 * @ORM\Table("sequence_enum")
 * @ORM\Entity(repositoryClass="Ya\CoreModelBundle\Entity\Repository\SequenceEnumRepository")
 */
class SequenceEnum
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
   * @ORM\Column(name="name", type="string", length=15)
   */
  protected $name;

  /**
   * @var ArrayCollection
   * @ORM\OneToMany(targetEntity="Observation", mappedBy="sequence")
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
   * @return SequenceEnum
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
   * Add observations
   *
   * @param \Ya\CoreModelBundle\Entity\Observation $observations
   * @return SequenceEnum
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
}