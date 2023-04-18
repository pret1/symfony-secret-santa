<?php

namespace App\EventSubscriber;

use App\Events\UserRegisteredEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Psr\Log\LoggerInterface;

class UserRegisteredSubscriber implements EventSubscriberInterface
{

    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {

        $this->logger = $logger;
    }

    public function onUserRegistered(UserRegisteredEvent $event)
    {
        $this->logger->info($event->getUser() . ' that user started custom event');
    }
    
    public static function getSubscribedEvents()
    {
        return [
            UserRegisteredEvent::class => 'onUserRegistered'
        ];
    }
}