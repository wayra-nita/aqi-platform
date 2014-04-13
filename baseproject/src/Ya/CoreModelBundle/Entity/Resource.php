<?php

namespace Ya\CoreModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\AccessType;

/**
 * Resoruce
 *
 * @ORM\Table("resource")
 * @ORM\Entity(repositoryClass="Ya\CoreModelBundle\Entity\Repository\ResourceRepository")
 * @ExclusionPolicy("none")
 */
class Resource
{
  // TODO: Support different types of resources, so far it will consider all resources as images
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
   * @ORM\Column(name="name", type="string", length=100, nullable=true)
   */
  protected $name;

  /**
   * @var string
   *
   * @ORM\Column(name="description", type="text", length=100, nullable=true)
   */
  protected $description;

  /**
   * @var string
   *
   * @ORM\Column(name="source", type="string", length=200, nullable=true)
   */
  protected $source;

  /**
   * @var string
   *
   * @ORM\Column(name="path", type="string", length=200)
   */
  protected $path;

  /**
   * @var float
   *
   * @ORM\Column(name="latitude", type="float")
   */
  protected $latitude;

  /**
   * @var float
   *
   * @ORM\Column(name="longitude", type="float")
   */
  protected $longitude;

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
     * @return Resource
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
     * Set description
     *
     * @param string $description
     * @return Resource
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

    /**
     * Set source
     *
     * @param string $source
     * @return Resource
     */
    public function setSource($source)
    {
        $this->source = $source;
    
        return $this;
    }

    /**
     * Get source
     *
     * @return string 
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * Set path
     *
     * @param string $path
     * @return Resource
     */
    public function setPath($path)
    {
        $this->path = $path;
    
        return $this;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set latitude
     *
     * @param float $latitude
     * @return Resource
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
     * @return Resource
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