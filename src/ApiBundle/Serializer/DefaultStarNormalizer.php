<?php

namespace ApiBundle\Serializer;

use ApiBundle\Service\ViewTypeNormalizerFinder;
use SkyBundle\Entity\Star;
use SkyBundle\Model\Element;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class DefaultStarNormalizer implements NormalizerInterface
{
    private $normalizer;

    private $viewTypeNormalizerFinder;

    public function __construct(ObjectNormalizer $normalizer, ViewTypeNormalizerFinder $viewTypeNormalizerFinder)
    {
        $this->normalizer = $normalizer;
        $this->viewTypeNormalizerFinder = $viewTypeNormalizerFinder;
    }

    public function normalize($object, $format = null, array $context = array())
    {
        $viewType = $context['viewType'] ?? null;
        $viewTypeNormalizer = $viewType ? $this->viewTypeNormalizerFinder->getNormalizerByViewType($viewType) : null;

        if (null !== $viewTypeNormalizer) {
            return $viewTypeNormalizer->normalize($object, $format, $context);
        }

        $data = $this->normalizer->normalize($object, $format, $context);

        if (empty($data) || empty($data['atoms'])) {
            return $data;
        }

        $elementsByName = array_flip(Element::LIST);
        foreach ($data['atoms'] as $key => $name) {
            $atomNumber = null;
            if (isset($elementsByName[$name])) {
                $atomNumber = $elementsByName[$name] + 1;
            }

            $data['atoms'][$key] = [
                'name' => $name,
                'atom_number' => $atomNumber,
            ];
        }

        return $data;
    }

    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof Star;
    }
}