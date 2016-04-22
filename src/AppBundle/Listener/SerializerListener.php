<?php

namespace AppBundle\Listener;


use JMS\Serializer\EventDispatcher\EventSubscriberInterface;
use JMS\Serializer\EventDispatcher\PreSerializeEvent;

class SerializerListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return array(
            array('event' => 'serializer.pre_serialize', 'method' => 'onPreSerialize'),
        );
    }

    public function onPreSerialize(PreSerializeEvent $event)
    {
        if (is_a($file = $event->getObject(), 'CoreDomain\Model\File\File')) {
            $file->setFullPath($_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST']);
        }
    }
}