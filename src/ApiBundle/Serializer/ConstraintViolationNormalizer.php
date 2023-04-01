<?php

namespace ApiBundle\Serializer;

use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Validator\ConstraintViolation;

class ConstraintViolationNormalizer implements NormalizerInterface
{

    public function normalize($object, $format = null, array $context = array())
    {
        if (!$object instanceof ConstraintViolation) {
            return [];
        }

        return [
            'property_path' => $object->getPropertyPath(),
            'message' => $object->getMessage(),
        ];
    }

    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof ConstraintViolation;
    }
}