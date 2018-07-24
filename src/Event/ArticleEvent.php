<?php

namespace App\Event;

use JMS\Serializer\EventDispatcher\EventSubscriberInterface;
use JMS\Serializer\EventDispatcher\ObjectEvent;

class ArticleEvent implements EventSubscriberInterface 
{
    
    public function onPostSerialize(ObjectEvent $e)
    {
        $now = new \Datetime();
        $e->getVisitor()->addData('created', $now->format('Y-m-d H:i:s'));
    }
    
    public static function getSubscribedEvents()
    {
        return [
                [
                    'event'  => 'serializer.post_serialize',
                    'method' => 'onPostSerialize'
                ]
            ];
    }
}