<?php

namespace ApiBundle\Service;

use ApiBundle\Serializer\ViewTypeNormalizerInterface;

class ViewTypeNormalizerFinder
{
    /**
     * @var ViewTypeNormalizerInterface[]
     */
    private $viewTypeNormalizers;

    public function __construct(array $viewTypeNormalizers = [])
    {
        $this->viewTypeNormalizers = [];

        foreach ($viewTypeNormalizers as $normalizer) {
            if ($normalizer instanceof ViewTypeNormalizerInterface) {
                $this->viewTypeNormalizers[] = $normalizer;
            }
        }
    }

    public function getNormalizerByViewType(string $viewType): ?ViewTypeNormalizerInterface
    {
        foreach ($this->viewTypeNormalizers as $normalizer) {
            if ($normalizer::getViewType() === $viewType) {
                return $normalizer;
            }
        }

        return null;
    }
}