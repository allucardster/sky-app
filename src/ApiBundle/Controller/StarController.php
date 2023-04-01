<?php

namespace ApiBundle\Controller;

use ApiBundle\Model\Request\CreateStarRequest;
use ApiBundle\Model\Request\UpdateStarRequest;
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

    /**
     * @Rest\Patch("/{id}")
     * @Sensio\ParamConverter("request", converter="fos_rest.request_body")
     *
     * @param Star $star
     * @param UpdateStarRequest $request
     * @param ConstraintViolationListInterface $constraintViolationList
     * @return View
     */
    public function update(
        Star $star,
        UpdateStarRequest $request,
        ConstraintViolationListInterface $constraintViolationList
    ): View {
        if ($constraintViolationList->count() > 0) {
            return View::create($constraintViolationList, Response::HTTP_BAD_REQUEST);
        }

        return View::create($this->getStarService()->updateStar($star, $request), Response::HTTP_OK);
    }

    /**
     * @Rest\Delete("/{id}")
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
     *
     * @param Star $star
     * @return void
     */
    public function delete(Star $star): void
    {
        $this->getStarService()->deleteStar($star);
    }
}