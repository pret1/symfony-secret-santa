<?php

namespace App\EventSubscriber;

use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class RequestDurationSubscriber implements EventSubscriberInterface
{
    private $startedAt;

    private LoggerInterface $logger;

    public function __construct(
        LoggerInterface $logger
    ) {
        $this->logger = $logger;
    }

    public function startTimer(RequestEvent $event): void
    {
        $this->startedAt = microtime(true);
    }

    public function endTimer(ResponseEvent $event): void
    {
        $this->logger->info(sprintf("Count response %f", (microtime(true) - $this->startedAt) * 1000));
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => 'startTimer',
            ResponseEvent::class => 'endTimer',
        ];
    }
}
