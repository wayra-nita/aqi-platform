<?php
/**
 * theming-store-symfony
 * Owner: Jonathan Claros
 */

namespace Ya\CoreModelBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

use JMS\Serializer\Annotation as Serializer;
use FSC\HateoasBundle\Annotation as Rest;


/**
 * Class Template
 * @package Ya\CoreModelBundle\Entity
 * @Serializer\XmlRoot("test")
 * @ORM\Table(name="test")
 * @ORM\Entity(repositoryClass="Ya\CoreModelBundle\Entity\Repository\TestRepository")
 */
class Test
{

  /**
   * @ORM\Column(type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue
   */
  private $id;
  /**
   * @ORM\Column(type="string", length=128)
   */
  private $title;
  /**
   * @ORM\Column(type="text", nullable=true)
   */
  private $description;
  /**
   * @Gedmo\Timestampable(on="create")
   * @ORM\Column(type="datetime")
   */
  private $created;
  /**
   * @Gedmo\Timestampable(on="update")
   * @ORM\Column(type="datetime", nullable=true)
   */
  private $updated;

  /**
   * basic creator
   */
  public function __construct()
  {
    $this->created = new \DateTime();
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
   * Set id
   *
   */
  public function setId($param)
  {
    $this->id = $param;
    return $this;
  }

  /**
   * Get title
   *
   * @return string
   */
  public function getTitle()
  {
    return $this->title;
  }

  /**
   * Set title
   *
   * @param string $title
   * @return Template
   */
  public function setTitle($title)
  {
    $this->title = $title;

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
   * Set description
   *
   * @param string $description
   * @return Template
   */
  public function setDescription($description)
  {
    $this->description = $description;

    return $this;
  }

  /**
   * Get created
   *
   * @return \DateTime
   */
  public function getCreated()
  {
    return $this->created;
  }

  /**
   * Set created
   *
   * @param \DateTime $created
   * @return Template
   */
  public function setCreated($created)
  {
    $this->created = $created;

    return $this;
  }

  /**
   * Get updated
   *
   * @return \DateTime
   */
  public function getUpdated()
  {
    return $this->updated;
  }

  /**
   * Set updated
   *
   * @param \DateTime $updated
   * @return Template
   */
  public function setUpdated($updated)
  {
    $this->updated = $updated;

    return $this;
  }
}