<?php

namespace ApiBundle\Controller;

use ApiBundle\Model\StarBasic;
use ApiBundle\Model\Request\CreateStarRequest;
use ApiBundle\Model\Request\UniqueStarsRequest;
use ApiBundle\Model\Request\UpdateStarRequest;
use FOS\RestBundle\Context\Context;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Sensio;
use SkyBundle\Entity\Star;
use SkyBundle\Service\StarService;
use Symfony\Component\HttpFoundation\Request;
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
     * # Responses
     *
     * - Status: `200 OK`. Response:
     * ```
     * [
     *     {
     *         "name": "Trisol-4",
     *         "radius": 7544,
     *         "temperature": 8777,
     *         "volume": 1798430455434.0227
     *     }
     * ]
     * ```
     *
     * - Status: `400 Bad Request`. Query params validation issues. Response:
     * ```
     * [
     *     {
     *         "property_path": "name",
     *         "message": "This value should not be blank."
     *     },
     *     {
     *         "property_path": "galaxy",
     *         "message": "This value should not be blank."
     *     },
     *     {
     *         "property_path": "atoms",
     *         "message": "You must select at least 1 choice."
     *     }
     * ]
     * ```
     *
     * @ApiDoc(
     *     section="api/star",
     *     description="Get sorted list of stars in a galaxy that has all specified atoms but in the same time all these atoms are not found in another galaxy.",
     *     filters={
     *          {"name"="sortBy", "dataType"="string", "required"=false, "description"="Allow order asc by given param. Supported values: size and temperature. Default value: size", "default"="size"},
     *          {"name"="viewType", "dataType"="string", "required"=false, "description"="Allow show the result in a different format. Supported values: basic. Default value: basic", "default"="basic" }
     *     },
     *     parameters={
     *          {"name"="foundIn", "dataType"="string", "required"=true, "description"="Galaxy name that has specified atoms"},
     *          {"name"="notFoundIn", "dataType"="string", "required"=true, "description"="Galaxy name that should not have specified atoms"},
     *          {"name"="atoms[0]", "dataType"="string", "required"=true, "description"="Allow set a list of unique atoms to search in `foundIn` galaxy. Add more params using `atoms[key]=atom`"},
     *     },
     *     statusCodes={
     *          200="Success",
     *          400="Failure"
     *     }
     * )
     *
     * @Rest\Get("/unique-stars")
     * @Sensio\ParamConverter("request", converter="request_query_param_converter")
     *
     * @param UniqueStarsRequest $request
     * @param ConstraintViolationListInterface $constraintViolationList
     * @return View
     */
    public function getUniqueStars(
        UniqueStarsRequest $request,
        ConstraintViolationListInterface $constraintViolationList
    ): View {
        if ($constraintViolationList->count() > 0) {
            return View::create($constraintViolationList, Response::HTTP_BAD_REQUEST);
        }

        $context = new Context();
        $context->setAttribute('viewType', $request->getViewType());

        $view = View::create($this->getStarService()->getUniqueStars($request), Response::HTTP_OK);
        $view->setContext($context);

        return $view;
    }

    /**
     * # Request
     *
     * - Request json body example:
     * ```
     * {
     *     "name": "Star 1",
     *     "galaxy": "Galaxy A",
     *     "radius": 1000.10,
     *     "temperature": 5600.66,
     *     "rotationFrequency": 78.5,
     *     "atoms": [
     *         "gold",
     *         "silver"
     *     ]
     * }
     * ```
     *
     * # Responses
     *
     * - Status: `201 Created`. Response:
     * ```
     * {
     *     "id": 80,
     *     "name": "Star 1",
     *     "galaxy": "Galaxy A",
     *     "radius": 1000.1,
     *     "temperature": 5600.66,
     *     "rotationFrequency": 78.5,
     *     "atoms": [
     *         {
     *             "name": "gold",
     *             "atom_number": 79
     *         },
     *         {
     *             "name": "silver",
     *             "atom_number": 47
     *         }
     *     ]
     * }
     * ```
     *
     * - Status: `400 Bad Request`. Validation issues. Response:
     * ```
     * [
     *     {
     *         "property_path": "name",
     *         "message": "This value should not be blank."
     *     },
     *     {
     *         "property_path": "galaxy",
     *         "message": "This value should not be blank."
     *     },
     *     {
     *         "property_path": "atoms",
     *         "message": "You must select at least 1 choice."
     *     }
     * ]
     * ```
     *
     * - Status: `400 Bad Request`. Response:
     * ```
     * {
     *     "code": 400,
     *     "message": "Unable to create the star. The given star name \"Star 1\" already exists in \"Galaxy A\""
     * }
     * ```
     *
     * @ApiDoc(
     *     section="api/star",
     *     description="Create a new star",
     *     statusCodes={
     *          201="Success",
     *          400="Failure"
     *     }
     * )
     *
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
     * # Responses
     *
     * - Status: `200 OK`. Response:
     * ```
     * {
     *     "id": 80,
     *     "name": "Star 1",
     *     "galaxy": "Galaxy A",
     *     "radius": 1000.1,
     *     "temperature": 5600.66,
     *     "rotationFrequency": 78.5,
     *     "atoms": [
     *         {
     *             "name": "gold",
     *             "atom_number": 79
     *         },
     *         {
     *             "name": "silver",
     *             "atom_number": 47
     *         }
     *     ]
     * }
     * ```
     *
     * - Status: `404 Not Found`. Response:
     * ```
     * {
     *      "code": 404,
     *      "message": "SkyBundle\\Entity\\Star object not found."
     * }
     * ```
     *
     * @ApiDoc(
     *     section="api/star",
     *     description="Read a star by given id",
     *     requirements={
     *          {
     *              "name"="id",
     *              "dataType"="integer",
     *              "requirement"="\d+",
     *              "description"="A Star id"
     *          }
     *     },
     *     statusCodes={
     *          200="Success",
     *          404="Not Found"
     *     }
     * )
     *
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
     * # Request
     *
     * - The request supports update one or more Star attributes. Request json body examples:
     * ```
     * // Specific values to update
     * {
     *     "galaxy": "Galaxy A-UP",
     *     "radius": 9999.10,
     * }
     * ```
     * ```
     * // All values to be updated at once
     * {
     *     "name": "Star 1-UP",
     *     "galaxy": "Galaxy A-UP",
     *     "radius": 9999.10,
     *     "temperature": 2455.66,
     *     "rotationFrequency": 24.5,
     *     "atoms": [
     *         "hydrogen",
     *         "helium"
     *     ]
     * }
     * ```
     *
     * # Responses
     *
     * - Status: `200 OK`. Response:
     * ```
     * {
     *     "id": 80,
     *     "name": "Star 1-UP",
     *     "galaxy": "Galaxy A-UP",
     *     "radius": 9999.1,
     *     "temperature": 2455.66,
     *     "rotationFrequency": 24.5,
     *     "atoms": [
     *         {
     *             "name": "hydrogen",
     *             "atom_number": 1
     *         },
     *         {
     *             "name": "helium",
     *             "atom_number": 2
     *         }
     *     ]
     * }
     * ```
     *
     * - Status: `400 Bad Request`. Validation issues. Response:
     * ```
     * [
     *     {
     *         "property_path": "radius",
     *         "message": "This value should be of type float."
     *     },
     *     {
     *         "property_path": "temperature",
     *         "message": "This value should be of type float."
     *     },
     *     {
     *         "property_path": "rotationFrequency",
     *         "message": "This value should be of type float."
     *     },
     *     {
     *         "property_path": "atoms",
     *         "message": "You must select at least 1 choice."
     *     }
     * ]
     * ```
     *
     * - Status: `404 Not Found`. Response:
     * ```
     * {
     *      "code": 404,
     *      "message": "SkyBundle\\Entity\\Star object not found."
     * }
     * ```
     *
     * @ApiDoc(
     *     section="api/star",
     *     description="Update a star by given id",
     *     requirements={
     *          {
     *              "name"="id",
     *              "dataType"="integer",
     *              "requirement"="\d+",
     *              "description"="A Star id"
     *          }
     *     },
     *     statusCodes={
     *          200="Success",
     *          400="Failure",
     *          404="Not Found"
     *     }
     * )
     *
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
     * # Responses
     *
     * - Status: `404 Not Found`. Response:
     * ```
     * {
     *      "code": 404,
     *      "message": "SkyBundle\\Entity\\Star object not found."
     * }
     * ```
     *
     * @ApiDoc(
     *     section="api/star",
     *     description="Delete a star by given id",
     *     requirements={
     *          {
     *              "name"="id",
     *              "dataType"="integer",
     *              "requirement"="\d+",
     *              "description"="A Star id"
     *          }
     *     },
     *     statusCodes={
     *          204="Success - No Content returned",
     *          404="Not Found"
     *     }
     * )
     *
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