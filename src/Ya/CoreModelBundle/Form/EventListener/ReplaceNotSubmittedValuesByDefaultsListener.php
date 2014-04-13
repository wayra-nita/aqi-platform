<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Ya\CoreModelBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ReplaceNotSubmittedValuesByDefaultsListener implements EventSubscriberInterface
{
  private $factory;
  private $ignoreRequiredFields;

  public function __construct(FormFactoryInterface $factory, $ignoreRequiredFields = true)
  {
    $this->factory = $factory;
    $this->ignoreRequiredFields = $ignoreRequiredFields;
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents()
  {
    return array(FormEvents::PRE_BIND => 'preBind');
  }

  /**
   * {@inheritdoc}
   */
  public function preBind(FormEvent $event)
  {
    $form = $event->getForm();
    $submittedData = $event->getData();

    if ($form->getConfig()->getCompound()) {
      foreach ($form->all() as $name => $child) {
        if (!isset($submittedData[$name])
            && (!$this->ignoreRequiredFields || !$child->isRequired())) {
          $submittedData[$name] = $child->getData();
        }
      }
    }

    $event->setData($submittedData);
  }
}