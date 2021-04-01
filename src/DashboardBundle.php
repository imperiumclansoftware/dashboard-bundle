<?php

namespace ICS\DashboardBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

// use Symfony\Contracts\Service\ServiceSubscriberInterface;

class DashboardBundle extends Bundle
{
    public function build(ContainerBuilder $builder)
    {
    }

    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}
