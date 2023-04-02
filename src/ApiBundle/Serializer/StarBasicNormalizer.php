<?php

namespace ApiBundle\Serializer;

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

        return [
            'name' => $object->getName(),
            'radius' => $object->getRadius(),
            'temperature' => $object->getTemperature(),
            'volume' => ((4/3) * pi() * pow($object->getRadius(), 3)),
        ];
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