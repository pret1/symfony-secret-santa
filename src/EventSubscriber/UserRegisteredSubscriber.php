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

    public function onUserRegistered(UserRegisteredEvent $event): void
    {
        $this->logger->info($event->getUser() . ' that user started custom event');
    }
    
    public static function getSubscribedEvents(): array
    {
        return [
            UserRegisteredEvent::class => 'onUserRegistered'
        ];
    }
}