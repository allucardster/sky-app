<?php

namespace ApiBundle\Controller;

use ApiBundle\Model\Request\CreateStarRequest;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Sensio;
use SkyBundle\Entity\Star;
use SkyBundle\Service\StarService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * @Rest\Route("/star")
 */
class StarController extends FOSRestController
{
    private function getStarService(): StarService
    {
        return $this->get('sky.star_service');
    }

    /**
     * @Rest\Post("")
     * @Sensio\ParamConverter("request", converter="fos_rest.request_body")
     *
     * @param CreateStarRequest $request
     * @param ConstraintViolationListInterface $constraintViolationList
     * @return View
     */
    public function create(
        CreateStarRequest $request,
        ConstraintViolationListInterface $constraintViolationList
    ): View {
        if ($constraintViolationList->count() > 0) {
            return View::create($constraintViolationList, Response::HTTP_BAD_REQUEST);
        }

        return View::create($this->getStarService()->createStar($request), Response::HTTP_CREATED);
    }

    /**
     * @Rest\Get("/{id}")
     * @Rest\View()
     *
     * @param Star $star
     * @return Star
     */
    public function read(Star $star): Star
    {
        return $star;
    }
}