<?php

namespace Rakut\ExperienceBundle\Form\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;

class RemoveExtraSubscriber implements EventSubscriberInterface
{
    public function onSubmitClientData(FormEvent $event)
    {
        $form = $event->getForm();
        $clientData = $event->getData();
        $newData = array();

        if (false == is_array($clientData)) {
            return;
        }

        foreach ($clientData as $key => $value)
        {
            if ($form->has($key)) {
                $newData[$key] = $value;
            }
        }

        $event->setData($newData);
    }

    static public function getSubscribedEvents()
    {
        return array(
            FormEvents::PRE_SUBMIT => 'onSubmitClientData',
        );
    }

}