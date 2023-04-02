<?php

namespace ApiBundle\Request\ParamConverter;

use FOS\RestBundle\Context\Context;
use FOS\RestBundle\Serializer\Serializer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RequestQueryParamConverter implements ParamConverterInterface
{
    private $serializer;
    private $validator;
    /**
     * @var string|null
     */
    private $validationErrorsArgument;

    public function __construct(
        Serializer $serializer,
        ValidatorInterface $validator = null,
        string $validationErrorsArgument = null
    ) {
        $this->serializer = $serializer;
        $this->validator = $validator;
        $this->validationErrorsArgument = $validationErrorsArgument;
    }

    public function apply(Request $request, ParamConverter $configuration)
    {
        $context = new Context();
        $query = $this->serializer->serialize($request->query->all(), 'json', $context);
        $object = $this->serializer->deserialize(
            $query,
            $configuration->getClass(),
            'json',
            $context
        );

        $request->attributes->set($configuration->getName(), $object);
        
        if (null !== $this->validator) {
            $errors = $this->validator->validate($object, null);

            $request->attributes->set(
                $this->validationErrorsArgument,
                $errors
            );
        }

        return true;
    }

    public function supports(ParamConverter $configuration)
    {
        return null !== $configuration->getClass() && 'request_query_param_converter' === $configuration->getConverter();
    }
}