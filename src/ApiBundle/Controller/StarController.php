<?php

namespace ApiBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use SkyBundle\Entity\Star;

/**
 * @Rest\Route("/star")
 */
class StarController
{
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