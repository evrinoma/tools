<?php


namespace App\LiveVideo\Subscriber;

use Evrinoma\LiveVideoBundle\Event\VideoEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class VideoSubscriber implements EventSubscriberInterface
{
    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents()
    {
        return [
            VideoEvent::class => 'onVideoEvent',
        ];
    }

    public function onVideoEvent(VideoEvent $event)
    {
        $event->addResponse(['titleHeader' => 'Video', 'pageName' => 'Video']);
    }
}