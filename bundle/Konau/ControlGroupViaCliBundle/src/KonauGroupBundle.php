<?php

namespace Konau\ControlGroupViaCliBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class KonauGroupBundle extends Bundle
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}