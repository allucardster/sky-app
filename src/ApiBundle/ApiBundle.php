<?php

namespace ApiBundle;

use ApiBundle\DependencyInjection\ViewTypeNormalizerFinderPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class ApiBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new ViewTypeNormalizerFinderPass());
    }
}
