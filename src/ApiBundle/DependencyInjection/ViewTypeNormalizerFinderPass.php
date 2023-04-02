<?php

namespace ApiBundle\DependencyInjection;

use ApiBundle\Serializer\ViewTypeNormalizerInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class ViewTypeNormalizerFinderPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('api.view_type_normalizer_finder')) {
            return;
        }

        $viewTypeNormalizers = $this->findTaggedViewTypeNormalizers('serializer.view_type.normalizer', $container);
        $container->getDefinition('api.view_type_normalizer_finder')->setArguments([$viewTypeNormalizers]);
    }

    private function findTaggedViewTypeNormalizers(string $tagName, ContainerBuilder $container): array
    {
        $services = $container->findTaggedServiceIds($tagName);

        if (empty($services)) {
            return [];
        }

        $viewTypeNormalizers = [];
        foreach ($services as $serviceId => $attributes) {
            $priority = $attributes[0]['priority'] ?? 0;
            $service = new Reference($serviceId);
            $viewTypeNormalizers[$priority][] = $service;
        }

        if (empty($viewTypeNormalizers)) {
            return [];
        }

        krsort($viewTypeNormalizers);

        return \call_user_func_array('array_merge', $viewTypeNormalizers);
    }
}