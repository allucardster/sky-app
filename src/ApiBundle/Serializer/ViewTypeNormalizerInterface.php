<?php

namespace ApiBundle\Serializer;

use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

interface ViewTypeNormalizerInterface extends NormalizerInterface
{
    public static function getViewType(): string;
}