<?php

namespace ApiBundle\Serializer;

use ApiBundle\Model\StarBasic;
use SkyBundle\Entity\Star;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class StarBasicNormalizer implements ViewTypeNormalizerInterface
{
    private $normalizer;

    public function __construct(ObjectNormalizer $normalizer)
    {
        $this->normalizer = $normalizer;
    }

    public function normalize($object, $format = null, array $context = array())
    {
        if (!$object instanceof Star) {
            return $this->normalizer->normalize($object, $format, $context);
        }

        return $this->normalizer->normalize(StarBasic::creteFrom($object), $format, $context);
    }

    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof Star;
    }

    public static function getViewType(): string
    {
        return 'basic';
    }
}