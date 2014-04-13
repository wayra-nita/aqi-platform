<?php
namespace Ya\CoreModelBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture as AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Ya\CoreModelBundle\Entity\User;

/**
 * Owner: Jonathan Claros 
 */

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
  /**
   * @var ContainerInterface
   */
  private $container;

  public function setContainer(ContainerInterface $container = null){
    $this->container = $container;
  }
  public function load(ObjectManager $manager)
  {
    $userAdmin = new User();
    $userAdmin->setUsername("chuck");
    $userAdmin->setEmail("chuck@ya.com");

    $encoder = $this->container->get("security.encoder_factory")
        ->getEncoder($userAdmin);

    $userAdmin->setPassword($encoder->encodePassword("123", $userAdmin->getSalt()));
    $userAdmin->addRole("ROLE_ADMIN");
    $userAdmin->setEnabled(true);
    $userAdmin->setSuperAdmin(true);

    $userPublisher = new User();
    $userPublisher->setUsername("ya");
    $userPublisher->setEmail("ya@ya.com");

    $encoder = $this->container->get("security.encoder_factory")
        ->getEncoder($userPublisher);

    $userPublisher->setPassword($encoder->encodePassword("123", $userPublisher->getSalt()));
    $userPublisher->addRole("ROLE_PUBLISHER");

    $userPublisher->setEnabled(true);
    $userPublisher->setSuperAdmin(false);

    $this->addReference('user-admin', $userAdmin);
    $this->addReference('user-publisher', $userPublisher);

  }

  public function getOrder()
  {
    return 1;
  }

}