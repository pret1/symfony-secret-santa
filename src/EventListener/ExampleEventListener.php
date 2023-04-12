<?php

namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\RequestEvent;
use Psr\Log\LoggerInterface;

class ExampleEventListener
{
    private LoggerInterface $logger;

    public function __construct(
        LoggerInterface $logger
    ) {
        $this->logger = $logger;
    }

    public function onEventHappen(RequestEvent $requestEvent): void
    {
//        dd(static::class);
        $this->logger->info(sprintf('Response out of ExampleEventListener %s', __METHOD__));
    }
}