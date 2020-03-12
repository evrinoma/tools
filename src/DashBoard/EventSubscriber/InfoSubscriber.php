<?php


namespace App\DashBoard\EventSubscriber;


use Evrinoma\DashBoardBundle\Event\InfoEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class InfoSubscriber implements EventSubscriberInterface
{
    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents()
    {
        return [
            InfoEvent::class => 'onInfo',
        ];
    }

    public function onInfo(InfoEvent $event)
    {
        $event->addInfo(['titleHeader' => 'Administration', 'pageName' => 'System Status']);
    }
}