<?php

namespace Konau\ControlGroupViaCliBundle;

use Konau\ControlGroupViaCliBundle\DependencyInjection\KonauControlGroupViaCliExtension;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;

class KonauGroupBundle extends AbstractBundle
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }

    public function getContainerExtension(): ?ExtensionInterface
    {
        return new KonauControlGroupViaCliExtension();
    }
}